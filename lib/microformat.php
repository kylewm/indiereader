<?php
namespace Microformat;

function mftype($parsed, $type) {
    return array_filter($parsed["items"], function($elt) use ($type) {
        return in_array($type, $elt["type"]);
    });
}

function scrubstrings($arr) {
    return array_map(function($elt) {
        if (gettype($elt) == "string")
            return htmlspecialchars($elt);
        return $elt;
    }, $arr);
}

function mfprop($mfs, $prop) {
    $props = array();
    if ($prop == "1") {
        if (isset($mfs[0])) return $mfs[0];
        return null;
    }
    foreach ($mfs as $mf) {
        if (isset($mf["properties"][$prop]))
            $thisprops = scrubstrings($mf["properties"][$prop]);
        else if ($prop == "children" && isset($mf[$prop]))
            $thisprops = $mf[$prop];
        else if (($prop == "html") && isset($mf[$prop]))
            $thisprops = array($mf[$prop]);
        else if (($prop == "value") && isset($mf[$prop]))
            $thisprops = scrubstrings(array($mf[$prop]));
        else
            continue;
        $props = array_merge($props, $thisprops);
    }
    return $props;
}

function mfpath($mf, $path) {
    $elts = array_filter(explode("/", $path), function($e){return $e!="";});
    return array_reduce($elts, function($result, $elt) {
        return mfprop($result, $elt);
    }, $mf);
}

class Entry {
    public $name = null;
    public $published = null;
    public $contentHtml = null;
    public $contentValue = null;
    public $photo = null;
    public $url = null;
    public $authorName = null;
    public $authorPhoto = null;
    public $authorUrl = null;
    public $syndication = null;
    public $replyTo = array();
    public $likeOf = array();
    public $repostOf = array();
    public $children = array();
    public $h = "entry";
    public $p = array(); // optional properties, eg. p-in-reply-to

    public function __construct($h = "entry", $p = array()) {
        $this->h = $h;
        $this->p = $p;
    }

    public function loadFromUrl($url) {
        $mf = \Mf2\fetch($url);
        return $this->loadFromMf(mftype($mf, "h-entry"));
    }

    public function loadFromHtml($html, $url = null) {
        $mf = \Mf2\parse($html, $url);
        return $this->loadFromMf(mftype($mf, "h-entry"));
    }

    public function loadFromMf($mf) {
        $this->name = mfpath($mf, "name/1");
        $this->published = mfpath($mf, "published/1");
        $this->contentHtml = mfpath($mf, "content/html/1");
        $this->contentValue = mfpath($mf, "content/value/1");
        $this->photo = mfpath($mf, "photo/1");
        $this->url = mfpath($mf, "url/1");
        $this->authorName = mfpath($mf, "author/name/1");
        $this->authorPhoto = mfpath($mf, "author/photo/1");
        $this->authorUrl = mfpath($mf, "author/url/1");
        $this->syndication = mfpath($mf, "syndication");
        foreach (mfpath($mf, "in-reply-to") as $elt) {
            $cite = new Entry("cite", array("in-reply-to"));
            if (is_array($elt))
                $cite->loadFromMf(array($elt));
            else
                $cite->url = $elt;
            $this->replyTo[] = $cite;
        }
        foreach (mfpath($mf, "like-of") as $elt) {
            $cite = new Entry("cite", array("like-of"));
            if (is_array($elt))
                $cite->loadFromMf(array($elt));
            else
                $cite->url = $elt;
            $this->likeOf[] = $cite;
        }
        foreach (mfpath($mf, "repost-of") as $elt) {
            $cite = new Entry("cite", array("repost-of"));
            if (is_array($elt))
                $cite->loadFromMf(array($elt));
            else
                $cite->url = $elt;
            $this->repostOf[] = $cite;
        }
        foreach (mfpath($mf, "children") as $elt) {
            $cite = new Entry("cite");
            $cite->loadFromMf(array($elt));
            $this->children[] = $cite;
        }
    }

    public function getRootClass() {
        $class = "h-" . $this->h;
        foreach ($this->p as $p)
            $class .= " p-$p";
        return $class;
    }

    public function getContentClass() {
        $class = "e-content";
        if ($this->isNote())
            $class .= " p-name note-content";
        return $class;
    }

    public function toHtml() {
        ob_start();
        //FIXME: use render()
        //require("tpl/entry.php");
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function references() {
        return array_map(function($e) {return $e->url;},
            array_merge($this->replyTo, $this->repostOf, $this->likeOf));
    }

    public function isReplyTo($url) {
        return in_array($url, $this->references());
    }

    public function isArticle() {
        return isset($this->name) && $this->name != $this->contentValue
            && count($this->references()) == 0;
    }

    public function isNote() {
        return !$this->isArticle() && !$this->isPhoto();
    }

    public function getLinks() {
        $links = $this->references();
        $doc = new \DOMDocument();
        if (!@$doc->loadHTML($this->contentHtml))
            return $links;
        foreach ($doc->getElementsByTagName("a") as $a)
            $links[] = $a->getAttribute("href");
        return $links;
    }

    public function isPhoto() {
        return isset($this->photo);
    }

}

?>
