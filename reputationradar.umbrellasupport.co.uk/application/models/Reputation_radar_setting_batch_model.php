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

    public function get_batch($id)
    {
        // $query    = $this->db->get($this->table_name);
        $query = $this->db->get_where($this->table_name, array('id' => $id));
        $response =  $query->result_array();
        return $response[0];
    }
    public function update_batch_increment($batch, $setting)
    {
        $index = $batch['index_pos'];
        $id    = $batch['id'];
        if(count($setting) > 0) {
            $index++;
        } else {
            $index = 0;
        }
        $this->db->set('index_pos', $index);
        $this->db->where('id', $id);
        $this->db->update($this->table_name);
    }

}