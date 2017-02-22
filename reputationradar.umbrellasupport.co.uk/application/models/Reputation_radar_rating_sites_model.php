<?php

class Reputation_radar_rating_sites_model extends CI_Model {

    public $title;
    public $content;
    public $date;
    private $table_name = 'wp_reputation_radar_rating_sites';

    public function get_last_ten_entries()
    {
        $query = $this->db->get($this->table_name, 10);
        return $query->result();
    }

    public function get_entry_by_batch_index($index)
    {
        $query = $this->db->get($this->table_name);
        $response = $query->result();

        return $response[$index];
    }
}