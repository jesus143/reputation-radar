<?php 
//include_once (dirname(__FILE__) . "/ReviewCentre.php");
//include_once (dirname(__FILE__) . "/TrustPilot.php");
error_reporting(0);
class RatingSite extends  CI_Controller {

    protected $companyUrl = '';
    protected $reviewCentre;
    protected $ratingSites = [];
    protected $trustPilot;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Reputation_radar_rating_sites_model', 'rating_site');
        $this->load->model('Reputation_radar_alert_model', 'alert');
        $this->ratingSites   = $this->rating_site->get_last_ten_entries();



    }

    public function Index()
    {
        $this->load->library('reviewcentre');
        $this->load->library('trustpilot');

        foreach($this->ratingSites as $key => $site):
            switch($site->url):
                case (strpos($site->url, 'uk.trustpilot.com') > 0):
                    print " trust pilot query url " . $site->url;
                    $trustPilot  = new TrustPilot();
                    $reviewCentreArray = $this->trustpilot->getBadRatings( $site->url );
                    $this->alert->checkIfAlertIsExistOrElseInsertAlertFromTrustPilot($reviewCentreArray, $site->partner_id);
                break;
                case (strpos($site->url, 'reviewcentre.com') > 0):
                    print " review center query url " . $site->url;
                    $reviewCentre  = new ReviewCentre();
                    $reviewCentreArray =  $this->reviewcentre->getBadRatings( $site->url );
                    $this->alert->checkIfAlertIsExistOrElseInsertAlertFromReviewCentre($reviewCentreArray, $site->partner_id);
                break;
                default:
                    break;
            endswitch;
        endforeach;
    }
}