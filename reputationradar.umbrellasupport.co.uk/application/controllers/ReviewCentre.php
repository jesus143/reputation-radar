<?php
error_reporting(0);

class ReviewCentre extends  CI_Controller {

    protected $companyUrl = '';

    public function Index()
    {
        $this->companyUrl = 'http://www.reviewcentre.com/reviews57568.html';
//        $this->companyUrl = 'http://www.reviewcentre.com/Airport-Transfers/Airport-Transfers-www-airporttransfers-co-uk-reviews_1706799';
//        $this->companyUrl = 'http://www.reviewcentre.com/reviews12632.html';

        $trustPilotData = $this->getReviewCentreComments();
        print "<pre>";
        print_r($trustPilotData);
        print "</pre>";
    }

    public function getReviewCentreComments($page=1)
    {
        // Initialized library
        $this->load->library('scraper');

        // Set url to scrape
        $this->scraper->capture_dom($this->companyUrl);

        // Start scrape and get comment time, content and rating
        $table_rows1 = $this->scraper->find(array(
                'name' => 'rows',
                'query' => '//*[contains(@class, "ReviewCommentWrapper")]',
                'subqueries' => array(
                    'date_created' => '//*[contains(@class, "ReviewCommentContentRight")]//p[1]//span[1]',
                    'full_name' => '//*[contains(@class, "ReviewCommentContentRight")]//p[1]//span[2]',
                    'content' => '//*[contains(@class, "ReviewCommentContentRight")]//p[2]',
                    'title' => '//*[contains(@class, "ReviewCommentContentRight")]//h3//a',
                    'star_1' => '//*[contains(@class, "starsLarge RatingStarsLarge_1-0")]',
                    'star_2' => '//*[contains(@class, "starsLarge RatingStarsLarge_2-0")]',
                    'star_3' => '//*[contains(@class, "starsLarge RatingStarsLarge_3-0")]',
                    'star_4' => '//*[contains(@class, "starsLarge RatingStarsLarge_4-0")]',
                    'star_5' => '//*[contains(@class, "starsLarge RatingStarsLarge_5-0")]',
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

            $table_rows1['rows'][$index]['total_star'] = $totalStar;
        }

        // Return array value
        return $table_rows1;

    }
}