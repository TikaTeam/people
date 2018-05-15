<?php

class init extends \Framework\cli {
    public function index()
    {
        //\Framework\show_404();
        $time_start = microtime(true);
        echo "<pre>";
        
        echo $this->settings();

        echo 'Total execution time in seconds: '. (microtime(true) - $time_start);
        echo "</pre>";
    }

    public function settings()
    {
        $table = __FUNCTION__;
        if (!$this-> db-> table_exists($table)) {
            $query = "CREATE TABLE IF NOT EXISTS $table (
						`id` bigint(20) NOT NULL auto_increment ,
						`site_title` text ,
						`font` text ,
						`site_keyword` text ,
						`site_description` text ,
						`site_copyright` text ,
						
						`contact_email` text ,
						`contact_address` text ,
						`contact_tel` text ,
						`contact_fax` text ,
						
						`contact_maps_latitute` text ,
						`contact_maps_long` text ,
						
						`contact_instagram` text ,
						`contact_telegram` text ,
						
						`page_khadamat_dandan` text ,
						`page_registeruser` text ,
						
						PRIMARY KEY  (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";
            $this->db->query($query);

            $data = array(
                'site_title' => "حامی کارت سلامت",
                'site_keyword' => "",
                'site_description' => "",
                'site_copyright' => "",
                'contact_email' => "",
                'contact_address' => "",
                'contact_tel' => "",
                'contact_fax' => "",
                'contact_maps_latitute' => "36.50",
                'contact_maps_long' => "53.01",
                'contact_instagram' => "",
                'contact_telegram' => "",
            );
            $this->db->insert($table, $data);

            return "Create $table<br/>";
        }
        return "Ok $table<br/>";
    }
}