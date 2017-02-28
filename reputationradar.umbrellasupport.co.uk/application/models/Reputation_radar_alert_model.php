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
        foreach($alertDataArr as $index => $data) {
            print "<hr>"; 
            print " page " . $index . ' ';  
            print "<pre>"; 
            print_r($data); 
            print "</pre>"; 

            $dotPossition = strpos($data['url'], '..'); 
            if(!empty($data['title']) and !empty($data['url']) and !empty($data['description'])) { 
                if($dotPossition   < 1) {  
                 print "<br> url dot possition $dotPossition ";

                    // set partner id in array 
                    $data['partner_id'] = $partner_id;
                    print "<br>test url " . htmlentities ($data['url']) ;
                     // select and current data this is the based to check if exist                    
                    $query = $this->db->select('*')
                        ->where('title', $data['title'])
                        ->where('partner_id', $data['partner_id'])
                        ->get($this->table_name); 

                    // if not exist then do insert new alert to specific partner
                   if ($query->num_rows() < 1) {  
                       $data['url'] = addhttp($data['url']);
                       if(isDomainAvailible($data['url'])) {    
                            print "<br>site is live";
                            print "<br> prepare to insert now ..."; 
                            if($this->db->insert($this->table_name, $data)) {
                                print "<br> Successfully inserted";  
                            }  else { 
                                print "<br> Failed to insert";  
                            }
                        }  // check site if online or not
                        else {
                            print "<br>no need to insert the site url is not live";  
                        }
                    } else {
                        print "<br> not insert because already exist"; 
                    }
                } 
                else {
                    print "<br> no insert because .. found in the url, meaning this url is cant be opened"; 
                }
            } //  check url, title and description
            else {
                print "<br> no insert because probably title, description or url is empty"; 
            }
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
                    print "<br> attempt to insert now ..."; 
                    if($this->db->insert($this->table_name, $data)) {
                        print "<br> Successfully inserted";  
                    }  else { 
                        print "<br> Failed to insert";  
                    }
                } else {
                    print "<br> not insert because already exist"; 

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