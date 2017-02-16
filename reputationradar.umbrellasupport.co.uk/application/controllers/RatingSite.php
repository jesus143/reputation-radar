<?php
include_once (dirname(__FILE__) . "/ReviewCentre.php");

class RatingSite extends  CI_Controller {

    protected $companyUrl = '';
    protected $reviewCentre;
    protected $ratingSites = [];

    function __construct()
    {
        parent::__construct();
        $this->load->model('Reputation_radar_rating_sites_model', 'rating_site');
        $this->load->model('Reputation_radar_alert_model', 'alert');
        $this->ratingSites   = $this->rating_site->get_last_ten_entries();
        $this->reviewCentre  = new ReviewCentre();
    }


    public function Index()
    {



        print "<pre>";
        foreach($this->ratingSites as $key => $site):



            /**
             * Get bad ratings and comments
             */
            $reviewCentreArray = $this->reviewCentre->getBadRatings( $site->url );


            print_r($reviewCentreArray);



            /**
             * Execute save to alert for specific bad comment rating
             * to partner specific partner and this is only
             * if alert is not exist via title
             */
             $this->alert->checkIfAlertIsExistOrElseInsertAlertFromReviewCentre($reviewCentreArray, $site->partner_id);

        endforeach;

    }






}