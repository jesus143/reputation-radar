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
        // get all partner settings
        // this also being manage in wordpress end
        $query = $this->db->get('wp_reputation_radar_settings');
        return $query->result();
    }
}