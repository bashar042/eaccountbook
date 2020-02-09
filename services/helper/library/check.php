<?php 
    class CHECK
    {
        public function check_post($vlaue)
        {
            $vlaue = htmlspecialchars(stripslashes($vlaue));
            $vlaue = str_ireplace("script", "blocked", $vlaue);
            $vlaue = mysql_escape_string($vlaue);
            return $vlaue;
        }
        public function getCurrentDateNTime()
        {
            $offset=6*60*60; //converting 6 hours to seconds.
            $dateFormat="Y-m-j H:i:s";
            $currentDateNTime = gmdate($dateFormat, time()+$offset);
            return $currentDateNTime;
        }

    }


?>