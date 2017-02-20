<?php
error_reporting(0);

class TrustPilot {



    protected $companyUrl = '';
    protected $url;
    protected $acceptedBadRating = 5;
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }


    public function Index()
    {
        $this->url = 'https://uk.trustpilot.com/review/www.parispass.com';

        $trustPilotData = $this->getTrustPilotComments();
        print "<pre>";
        print_r($trustPilotData);
        print "</pre>";
    }

    public function test()
    {
        print "Test";
    }

    public function getBadRatings($url)
    {

        $this->url = $url;

        $trustPilotData           = $this->getTrustPilotComments();

        $trustPilotDataBadComment = $this->getReviewCentreBadRating($trustPilotData['rows']);

        return $trustPilotDataBadComment;
    }

    private function getReviewCentreBadRating($trustPilotData)
    {
        $data = [];

        foreach($trustPilotData as $review) {

            if($review['total_star'] <= $this->acceptedBadRating) {

                $data[] = [
                    'description' => strip_tags($review['content']),
                    'person_name' => strip_tags(change_long_space_to_sing_space($review['full_name'])),
                    'url' => $this->url,
                    'rate' => $review['total_star'],
                ];
            }
        }
        return $data;
    }

    public function getTrustPilotComments()
    {

        // Initialized library
        $this->CI->load->library('scraper');


        // Set url to scrape
        $this->CI->scraper->capture_dom($this->url);


        // Start scrape and get comment time, content and rating
        $table_rows1 = $this->CI->scraper->find(array(
                'name' => 'rows',
                'query' => '//div[@id="reviews-container"]//*[contains(@class, "review-info")]',
                'subqueries' => array(
                    'time' => '//time',
                    'content' => '//*[contains(@class, "review-info")]//div[contains(@class, "review-body")]',
                    'star_1'=>'//*[contains(@class, "review-info")]//*[contains(@class, "count-1")]//@src',
                    'star_2'=>'//*[contains(@class, "review-info")]//*[contains(@class, "count-2")]//@src',
                    'star_3'=>'//*[contains(@class, "review-info")]//*[contains(@class, "count-3")]//@src',
                    'star_4'=>'//*[contains(@class, "review-info")]//*[contains(@class, "count-4")]//@src',
                    'star_5'=>'//*[contains(@class, "review-info")]//*[contains(@class, "count-5")]//@src',
                ),
             )
         );

        // Start scrape and get comment name
        $table_rows2 = $this->CI->scraper->find(array(
                'name' => 'rows',
                'query' => '//div[@id="reviews-container"]//*[contains(@class, "user-review-name-link")]',
                'subqueries' => array(
                    'full_name' => '//a'
                ),
            )
        );

        // Merge Comment time, content, rating and full name
        foreach($table_rows1['rows'] as $index => $value) {

            if(!empty($value['star_1'])){
                $totalStar = 1;
            } else if(!empty($value['star_2'])){
                $totalStar = 2;
            } else if(!empty($value['star_3'])){
                $totalStar = 3;
            } else if(!empty($value['star_4'])){
                $totalStar = 4;
            } else {
                $totalStar = 5;
            }


            $table_rows1['rows'][$index]['full_name'] = $table_rows2['rows'][$index]['full_name'];
            $table_rows1['rows'][$index]['total_star'] = $totalStar;
        }

        // Return array value
        return $table_rows1;

    }
}