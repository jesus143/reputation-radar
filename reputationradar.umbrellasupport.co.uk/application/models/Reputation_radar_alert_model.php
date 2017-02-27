<?php

class Reputation_radar_alert_model extends CI_Model {

    public $title;
    public $content;
    public $date;
    private $table_name = 'wp_reputation_radar_alert';

    public function get_last_ten_entries()
    {
        $query = $this->db->get($this->table_name, 10);
        return $query->result();
    }

    // check and insert for google scrape
    public function checkIfAlertIsExistOrElseInsertAlert($alertDataArr, $partner_id)
    {
        foreach($alertDataArr as $data) {
            if(!empty($data['title']) and !empty($data['url']) and !empty($data['description'])) { 
                if(isDomainAvailible($data['url'])) {   
                    // set partner id in array 
                    $data['partner_id'] = $partner_id;
                    print "test url " . htmlentities ($data['url']) ;
                     // select and current data this is the based to check if exist                    
                    $query = $this->db->select('*')
                        ->where('url',  htmlentities ($data['url']))
                        ->where('partner_id', $data['partner_id'])
                        ->get($this->table_name); 
                    // if not exist then do insert new alert to specific partner
                    if ($query->num_rows() < 1) {
                        $this->db->insert($this->table_name, $data);
                    }
                }  // check site if online or not
            } //  check url, title and description
        }
    } 

    // check and insert for review centre site, rating site
    public function checkIfAlertIsExistOrElseInsertAlertFromReviewCentre($alertDataArr, $partner_id)
    {
        foreach($alertDataArr as $data) {
            if(!empty($data['title']) and !empty($data['url']) and !empty($data['description'])) {
                // set partner id in array
                $data['partner_id'] = $partner_id; 
                
                // select and current data this is the based to check if exist
                $query = $this->db->select('*')
                    ->where('title',  htmlentities ($data['title']))
                    ->where('partner_id', htmlentities ($data['partner_id']))
                    ->get($this->table_name);

                // if not exist then do insert new alert to specific partner
                if ($query->num_rows() < 1) {
                    $this->db->insert($this->table_name, $data);
                }
            }
        }
    }

    // check and insert for review centre site, rating site
    public function checkIfAlertIsExistOrElseInsertAlertFromTrustPilot($alertDataArr, $partner_id)
    {


        foreach($alertDataArr as $data) {
            if(!empty($data['url']) and !empty($data['description'])) {
                // set partner id in array
                $data['partner_id'] = $partner_id;

                // select and current data this is the based to check if exist
                $query = $this->db->select('*')
                    ->where('description', htmlentities ($data['description']))
                    ->where('partner_id', htmlentities ($data['partner_id']))
                    ->get($this->table_name);

                // if not exist then do insert new alert to specific partner
                if ($query->num_rows() < 1) {
                    $this->db->insert($this->table_name, $data);
                }
            }
        }
    }



}