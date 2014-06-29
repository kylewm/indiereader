<!doctype html>
<html lang="en">
  <head>
    <title><?= $this->title ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="pingback" href="https://webmention.io/aaronpk/xmlrpc" />
    <link rel="webmention" href="https://webmention.io/aaronpk/webmention" />

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- standard viewport tag to set the viewport to the device's width
      , Android 2.3 devices need this so 100% width works properly and
      doesn't allow children to blow up the viewport width-->
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" />
    <!-- width=device-width causes the iPhone 5 to letterbox the app, so
      we want to exclude it for iPhone 5 to allow full screen apps -->
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)" />

    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <link rel="apple-touch-icon" sizes="57x57" href="/images/indiereader-icon-57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/indiereader-icon-72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/indiereader-icon-114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/indiereader-icon-144.png">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <script src="/js/jquery-1.7.1.min.js"></script>
  </head>

<body role="document">

<div class="page">

  <div class="container">
    <?= $this->fetch($this->page . '.php') ?>
  </div>

  <div class="footer">
    <div class="nav">
      <ul class="nav navbar-nav">

        <? if(session('me')) { ?>
          <li><a href="/new">New Post</a></li>
        <? } ?>

        <li><a href="/docs">Docs</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <? if(session('me')) { ?>
          <li><span class="navbar-text"><?= preg_replace('/https?:\/\//','',session('me')) ?></span></li>
          <li><a href="/signout">Sign Out</a></li>
        <? } else if(property_exists($this, 'authorizing')) { ?>
          <li class="navbar-text"><?= $this->authorizing ?></li>
        <? } else { ?>
          <form action="/auth/start" method="get" class="navbar-form">
            <input type="text" name="me" placeholder="yourdomain.com" class="form-control" />
            <button type="submit" class="btn">Sign In</button>
            <input type="hidden" name="redirect_uri" value="http<?= Config::$ssl ? 's' : '' ?>://<?= $_SERVER['SERVER_NAME'] ?>/indieauth" />
          </form>
        <? } ?>

      </ul>
    </div>

    <p class="credits">
      This code is <a href="https://github.com/benwerd/indiereader">open source</a>. 
      Feel free to send a pull request, or <a href="https://github.com/benwerd/indiereader/issues">file an issue</a>.
    </p>
  </div>
</div>

</body>
</html>