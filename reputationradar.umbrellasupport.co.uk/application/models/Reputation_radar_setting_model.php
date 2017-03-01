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

    public function composeSearchKeyword($keyword, $keywordSetting)
    {
        $newKeyword = '';

        switch($keywordSetting):
            case "Broad match":

                // keyword

                $newKeyword = $keyword;

                break;
            case "Broad match modifier":

                    // +keyword1 +keyword2

                    $newKeyword = $this->addCharPerFirstWord($keyword);

                break;
            case "Phrase match":

                    // "keyword"

                    $newKeyword =   '"'. $keyword . '"';

                break;
            case "Exact match":

                    // [keyword]

                    $newKeyword =   '['. $keyword . ']';

                break;
            case "Negative match":

                    // -keyword

                    $newKeyword = $this->addCharPerFirstWord($keyword, '-');

                break;
            default:
                break;
        endswitch;

        return $newKeyword;
    }

    private function addCharPerFirstWord($str, $chr='+')
    {
        $keywordArr = explode(' ', $str);
        $newKeyword = '';
        $counter = 0;
        foreach($keywordArr as $keyword) {
            $newKeyword .= $chr.$keyword;
            if($counter < count($keywordArr)-1) {
                $newKeyword .= ' ';
            }
            $counter++;
        }

        return $newKeyword;
    }

}