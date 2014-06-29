<?php

    class Retrieval {

        /**
         * Retrieves a
         * @param int $after Optionally, the epoch timestamp before which something must have been updated
         * @return array|IdiormResultSet
         */
        function getFeedsToPoll($after = 0) {

            /*
             * SELECT `feed`.*, count(`subscription`.id) as subscribers
             * FROM `feed`
             * join `subscription` on `feed`.id = `subscription`.feed_id
             * group by `subscription`.feed_id
             * having subscribers > 0
             */

            $query = ORM::for_table('feed')
                ->select('feed.*')
                ->select_expr('count(subscription.feed_id)', 'subscribers')
                ->join('subscription', array('feed.id', '=', 'subscription.feed_id'))
                ->group_by('subscription.feed_id')
                ->having_raw('subscribers > 0');

            if ($after) {
                $after = (int) $after;
                $query->where_lt('last_retrieved',date("Y-m-d H:i:s", $after));
            }

            return $query->find_many();

        }

        /**
         * Poll feeds. Optionally, supply a list of feed objects - otherwise it'll work it out.
         * @param bool $feeds Optionally, a list of feeds.
         */
        function pollFeeds($feeds = false) {

            if ($feeds === false) {
                $feeds = $this->getFeedsToPoll();
            }

            if (!empty($feeds) && is_array($feeds)) {

                foreach($feeds as $feed) {
                    if (!empty($feed->feed_url)) {



                    }
                }

            }

        }

    }