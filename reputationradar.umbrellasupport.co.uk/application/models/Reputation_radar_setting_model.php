<?php

class  Reputation_radar_setting_model extends CI_Model {

    public $title;
    public $content;
    public $date;
    private $table_name = 'wp_reputation_radar_settings';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_last_ten_entries()
    {
        $query = $this->db->get($this->table_name);
        return $query->result();
    }
    public function get_entry_by_batch_index($index)
    {
        $query = $this->db->get($this->table_name);
        $response = $query->result_array();

        return $response[$index];

        //        print "<pre>";
        //        print_R($results);
        //        exit;
    }
}