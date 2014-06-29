<?php

    class Subscriptions
    {

        public $user_id;

        /**
         * Construct a subscription object, initialized either with the current session user or a specified user ID
         * @param int $user_id If specified, sets this as the user to perform subscription actions on (default: logged in user)
         */
        function __construct($user_id = 0)
        {

            if (empty($user_id)) {
                if (!empty($_SESSION['user_id'])) {
                    $this->user_id = (int)$_SESSION['user_id'];
                } else {
                    $this->user_id = false;
                }
            } else {
                $this->user_id = (int)$user_id;
            }

        }

        /**
         * Retrieves a user's current subscriptions from the database
         * @return bool
         */
        function getSubscribedFeeds()
        {

            if (empty($this->user_id)) {
                return false;
            }

            return ORM::for_table('feed')
                ->join('subscription', array('feed.id', '=', 'subscription.feed_id'))
                ->where('subscription.user_id', $this->user_id)
                ->find_many();

        }

        /**
         * Retrieve an array of feeds from a specified URL
         * @param $url
         * @return array
         */
        function getFeedsFromURL($url)
        {

            $feeds = array();
            $http = new HTTP();

            if ($feed_page = $http->get($url)) {

                $parser = new \mf2\Parser($feed_page, $url);
                $content = $parser->parse();

                if (!empty($content['items'])) {
                    foreach($content['items'] as $item) {
                        if (in_array('h-feed',$item['type'])) {
                            if (!empty($item['children'])) {
                                foreach($item['children'] as $child) {

                                    if (!empty($child['properties']['feed'])) {

                                        $feed = new stdClass();     // We should probably change this
                                        $feed->feed_url = $child['properties']['feed'][0];
                                        $feed->name = $child['properties']['name'][0];
                                        $feed->homepage_url = $child['properties']['url'][0];

                                        $feeds[] = $feed;

                                    }

                                }
                            }
                        }
                    }
                }

            }

            return $feeds;

        }

        /**
         * Given a feed structure, updates or adds that feed to the database.
         * Expects an object with properties name, feed_url and homepage_url.
         * @param $feed
         * @return bool|null
         */
        function updateFeedDetails($feed)
        {

            if (empty($feed->feed_url)) {
                return false;
            }

            if ($feeds = ORM::for_table('feed')->where('feed_url',$feed->feed_url)->find_many()) {
                foreach($feeds as $row) {
                    $row->set(array(
                        'name' => $feed->name,
                        'homepage_url' => $feed->homepage_url
                    ));
                    $row->save();
                    return $row->id;
                }
            } else {
                $row = ORM::for_table('feed')->create();
                $row->name = $feed->name;
                $row->feed_url = $feed->feed_url;
                $row->homepage_url = $feed->homepage_url;
                $row->last_retrieved = date("Y-m-d H:i:s");
                $row->created = date("Y-m-d H:i:s");
                $row->updated = date("Y-m-d H:i:s");
                $row->save();
                return $row->id;
            }
            return false;

        }

        /**
         * Subscribes the current user to the specified feed ID
         * @param $feed_id
         * @return bool
         */
        function subscribeToFeed($feed_id) {

            if (empty($this->user_id)) {
                return false;
            }

            $subscription = ORM::for_table('subscription')->create();
            $subscription->user_id = $this->user_id;
            $subscription->feed_id = (int) $feed_id;
            return $subscription->save();

        }

        /**
         * Unsubscribes the current user from the specified feed ID
         * @param $feed_id
         * @return bool
         */
        function unsubscribeFromFeed($feed_id) {

            if (empty($this->user_id)) {
                return false;
            }

            ORM::for_table('subscription')->where( 'user_id',  $this->user_id)->where('feed_id', $feed_id)->delete();

        }

        /**
         * Refresh the user's subscriptions from an array of feed objects
         *
         * @param $feeds
         * @return bool
         */
        function refreshUserSubscriptions($feeds)
        {

            if (empty($this->user_id)) {
                return false;
            }

            ORM::for_table('subscription')->where('user_id',$this->user_id)->delete();

            if (!empty($feeds)) {
                foreach($feeds as $feed) {

                    if ($feed_id = $this->updateFeedDetails($feed)) {
                        $this->subscribeToFeed($feed_id);
                    }

                }
            }

        }

        /**
         * Refresh the user's subscriptions from a URL
         * @param $url
         * @return bool
         */
        function refreshUserSubscriptionsFromURL($url)
        {

            if (empty($this->user_id)) {
                return false;
            }

            return $this->refreshUserSubscriptions($this->getFeedsFromURL($url));

        }

    }
