<?php
error_reporting(0);

class Google extends  CI_Controller
{

    protected $companyUrl = '';

    public function Index()
    {
        $this->companyUrl = 'https://www.google.com.ph/search?num=50&q=love+me+like+you+do';
        // $trustPilotData = $this->getReviewCentreComments();
        $this->getGoogleData();
    }


    public function getGoogleData()
    {


        print "<html>";
        print "  <meta charset='UTF-8'>";



        $this->load->library('simple_html_dom');

        $html = file_get_html($this->companyUrl);

        $i=0;
  
        print "<pre>";
        foreach($html->find('div.g') as $search) {

                $i++;

                $title = $search->find('a', 0);
                $link = $search->find('cite', 0);


                $description = $search->find('span.st', 0);


            print "  $i ";

            if(!empty($title)) {
                print "title text = " . $title->text();
            }

            if(!empty($link)) {
                print "title text = <a href='" . $link->text() . "'  > link </a>";
            }

            if(!empty($description)) {
                print "title text = " . $description->text();
            }

            print "<hr><br>";


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