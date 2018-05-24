<?php

class init extends \Framework\cli {
    public function index()
    {
        //\Framework\show_404();
        $time_start = microtime(true);
        echo "<pre>";
        
        //echo $this->settings();

        echo 'Total execution time in seconds: '. (microtime(true) - $time_start);
        echo "</pre>";
    }
}