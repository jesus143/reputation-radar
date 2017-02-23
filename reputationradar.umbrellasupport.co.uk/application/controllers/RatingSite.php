<?php 
//include_once (dirname(__FILE__) . "/ReviewCentre.php");
//include_once (dirname(__FILE__) . "/TrustPilot.php");
error_reporting(0);
class RatingSite extends  CI_Controller {

    protected $companyUrl = '';
    protected $reviewCentre;
    protected $ratingSites = [];
    protected $trustPilot;
    protected $batch_id = 0;
    protected $url;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Reputation_radar_rating_sites_model', 'rating_site');
        $this->load->model('Reputation_radar_alert_model', 'alert');
        $this->load->model('Reputation_radar_setting_batch_model', 'google_batch');
        $this->ratingSites   = $this->rating_site->get_last_ten_entries();
        $this->batch_id = 2;

    }




    public function Index()
    {
        print "<pre>";

        // get from database tables
        $batch = $this->google_batch->get_batch($this->batch_id);
        $site = $this->rating_site->get_entry_by_batch_index($batch['index']);

        //
        print_r($site);

        // update settings batch now
        $this->google_batch->update_batch_increment($batch, $site);

        // load libraries
        $this->load->library('reviewcentre');
        $this->load->library('trustpilot');

        // save alert data
        if (strpos($site->url, 'uk.trustpilot.com') > 0) {
            print " trust pilot query url " . $site->url;
            $trustPilot = new TrustPilot();
            $reviewCentreArray = $this->trustpilot->getBadRatings($site->url);
            $this->alert->checkIfAlertIsExistOrElseInsertAlertFromTrustPilot($reviewCentreArray, $site->partner_id);
        }elseif (strpos($site->url, 'reviewcentre.com') > 0) {
            print " review center query url " . $site->url;
            $reviewCentre = new ReviewCentre();
            $reviewCentreArray = $this->reviewcentre->getBadRatings($site->url);
            $this->alert->checkIfAlertIsExistOrElseInsertAlertFromReviewCentre($reviewCentreArray, $site->partner_id);
        } else {

        }


    }
}