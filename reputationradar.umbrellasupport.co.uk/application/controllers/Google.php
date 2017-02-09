<?php
error_reporting(0);

class Google extends  CI_Controller
{

    protected $companyUrl = '';

    public function Index()
    {
        $this->companyUrl = 'https://www.google.com.ph/search?num=100&q=jesus+erwin+suarez';
//        $trustPilotData = $this->getReviewCentreComments();
        $this->getGoogleData();
    }


    public function getGoogleData()
    {
        $this->load->library('simple_html_dom');

        $html = file_get_html('https://www.google.com.ph/search?num=10&newwindow=1&q=');

        $i=0;

        foreach($html->find('div.g') as $search) {

            $i++;
            $link1 = $search->find('a', 0);

            $link2 = $search->find('cite', 0);
            $link3 = $search->find('span.st', 0);

            print "<br>" . $i .'  '. $link1->text()  . ' ' .$link2->text() . ' <br><b>' . $link3->text() . '</b>' ;

        }
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
                'query' => '//*[@id="rso"]/div/div/div[1]/div/'
            )
        );

        print "<pre>";
        print_r($table_rows1);
    }
}