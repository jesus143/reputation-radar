<?php
error_reporting(0);

class ReviewCentre {

    protected $companyUrl = '';
    protected $url;
    protected $acceptedBadRating = 3;
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function Index()
    {
        //  $this->execute('http://www.reviewcentre.com/reviews57568.html');
    }

    public function test() {
        print "testing here";
    }

    public function getBadRatings($url)
    {
        $this->url = $url;

        $trustPilotData           = $this->getReviewCentreComments();
        $trustPilotDataBadComment = $this->getReviewCentreBadRating($trustPilotData['rows']);
        return $trustPilotDataBadComment;
    }

    private function getReviewCentreBadRating($trustPilotData)
    {
        $data = [];

        foreach($trustPilotData as $review) {

            if($review['total_star'] <= $this->acceptedBadRating) {

                $data[] = [
                    'title' => strip_tags(htmlentities($review['title'])),
                    'description' => strip_tags(htmlentities($review['content'])),
                    'person_name' => strip_tags(htmlentities(change_long_space_to_sing_space($review['full_name']))),
                    'url' => htmlentities($this->url),
                    'rate' => $review['total_star'],
                ];
            }
        }
        return $data;
    }

    public function getReviewCentreComments()
    {
        $this->CI->load->library('scraper');
        $this->CI->scraper->capture_dom($this->url);

        // Start scrape and get comment time, content and rating
        $table_rows1 = $this->CI->scraper->find(array(
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