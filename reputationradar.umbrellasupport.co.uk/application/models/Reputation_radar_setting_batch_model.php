<?php

class  Reputation_radar_setting_batch_model extends CI_Model {

    public $title;
    public $content;
    public $date;
    private $table_name = 'wp_reputation_radar_setting_batch';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_batch()
    {
        $query    = $this->db->get($this->table_name);
        $response =  $query->result_array();
        return $response [0];
    }
    public function update_batch_increment($batch, $setting)
    {
        $index = $batch['index'];
        $id    = $batch['id'];
        if(count($setting) > 0) {
            $index++;
        } else {
            $index = 0;
        }
        $this->db->set('index', $index);
        $this->db->where('id', $id);
        $this->db->update($this->table_name);
    }

}