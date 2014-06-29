<?php

    class HTTP {

        public $last_status = 0;

        /**
         * Gets content from a URL; false on an error code
         * @param $url
         * @return bool|mixed
         */
        function get($url) {

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_HTTPGET, true);

            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl_handle, CURLOPT_AUTOREFERER, true);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, "IndieReader");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);

            $buffer      = curl_exec($curl_handle);
            $http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

            $this->last_status = $http_status;

            if ($error = curl_error($curl_handle)) {
                error_log($error);
            }

            curl_close($curl_handle);

            if ($http_status == 200) {
                return $buffer;
            }

            return false;

        }

        /**
         * Retrieve the HTTP status from the last operation
         * @return int
         */
        function getLastStatus() {
            return $this->last_status;
        }

    }