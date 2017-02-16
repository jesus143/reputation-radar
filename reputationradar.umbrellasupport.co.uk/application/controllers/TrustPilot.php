<?php
error_reporting(0);

class TrustPilot extends  CI_Controller {



    protected $companyUrl = '';

    public function Index()
    {
        $this->companyUrl = 'https://uk.trustpilot.com/review/www.parispass.com';

        $trustPilotData = $this->getTrustPilotComments();
        print "<pre>";
        print_r($trustPilotData);
        print "</pre>";
    }


    public function getTrustPilotComments($page=1)
    {

        // Initialized library
        $this->load->library('scraper');


        // Set url to scrape
        $this->scraper->capture_dom($this->companyUrl);


        // Start scrape and get comment time, content and rating
        $table_rows1 = $this->scraper->find(array(
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
        $table_rows2 = $this->scraper->find(array(
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