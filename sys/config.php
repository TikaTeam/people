<?php
    namespace Framework;

    class config
    {
        static $base_url ='http://localhost/people';

        static $default ='tab/home';

        static $dbhost ='localhost';
        static $dbname ='db_people';
        static $dbuser ='root';
        static $dbpass ='';
        static $dbencoding ='utf8';
    }

    function base_url()
    {
        $out=rtrim(config::$base_url,'/');
        return $out. '/';
    }