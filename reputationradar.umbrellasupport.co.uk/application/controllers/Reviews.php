<?php
error_reporting(0);

class Reviews extends  CI_Controller {



    protected $companyUrl = '';

    public function Index()
    {
        print "test";
        $this->companyUrl = 'https://www.reviews.co.uk/company-reviews/store/uk-tights';
        $this->getReviewsComments();
    }


    public function getReviewsComments($page=1)
    {

        // Initialized library
        $this->load->library('scraper');


        // Set url to scrape
        $this->scraper->capture_dom($this->companyUrl);


        // Start scrape and get comment time, content and rating
        $table_rows1 = $this->scraper->find(array(
                'name' => 'rows',
                'query' => '//*[contains(@class, "ReviewsPage__right")]//*[contains(@class, "Review ")]',
                'subqueries' => array(
                    'full_name' => '//div[2]/div[1]/span',
                    'content' => '//div[3]/div[2]/span',
                    'star_1' => '/div[2]/div[2]/div//i[1]/@class',
                ),
             )
         );

        print "<pre>";
            print_r($table_rows1);
        print "</pre>";



    }


    public function test()
    {

        $doc = new DOMDocument;

        // We don't want to bother with white spaces
        $doc->preserveWhiteSpace = false;

        $doc->Load('https://www.reviews.co.uk/company-reviews/store/uk-tights');

        $xpath = new DOMXPath($doc);

        // We starts from the root element
        $query = '/html/body/div[4]/div[2]/div[3]/div[1]/div[2]/div[2]/div/i';

        $entries = $xpath->query($query);

        foreach ($entries as $entry) {
            echo " TEST Found {$entry->previousSibling->previousSibling->nodeValue}," .
                " by {$entry->previousSibling->nodeValue}\n";
        }
    }
}