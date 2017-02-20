<?php
error_reporting(0);

class Google extends  CI_Controller
{

    protected $companyUrl = '';

    public function Index()
    {

        print "<pre>";
        // load model
        $this->load->model('Reputation_radar_setting_model', 'setting');
        $this->load->model('Reputation_radar_alert_model', 'alert');
        $this->load->model('Reputation_radar_setting_batch_model', 'google_batch');

        // get all the entries for the partner settings
        $batch = $this->google_batch->get_batch();

        $setting = $this->setting->get_entry_by_batch_index($batch['index']);



        print_r($setting);


        // url encoded for google keyword
        $keyword = urlencode($setting['company_search_keyword']);

        // compose url ready for scrape to google
        $this->companyUrl = 'https://www.google.com.ph/search?num=10&q=' . $keyword;

        // scrape google data
        $results = $this->getGoogleData();

        //check if exist then do nothing but if not then do insert
        $this->alert->checkIfAlertIsExistOrElseInsertAlert($results, $setting['partner_id']);

        // update settings batch now
        $this->google_batch->update_batch_increment($batch, $setting);
    }

    public function getGoogleData()
    {

        // initialized data
        $result = [];
        $i=0;


        // load dom library for php
        $this->load->library('simple_html_dom');

        // results from website query, for now we do search in google
        // but in the future we may be able to search in bing, yahoo and other
        // search engine sites
        $html = file_get_html($this->companyUrl);

        // start foreach data through the results of website query via dom
        foreach($html->find('div.g') as $search) {

            // get title of the result
            $title = $search->find('a', 0);

            // get link of the result
            $link = $search->find('cite', 0);

            // get description of the result
            $description = $search->find('span.st', 0);

            // title results store to array
            if(!empty($title)) {
                $result[$i]['title'] = $title->text();
            }

            // link results store to array
            if(!empty($link)) {
                $result[$i]['url'] = $link->text();
            }

            // description results store to array
            if(!empty($description)) {

                $result[$i]['description'] = $description->text();
            }

            // increment counter for array
            $i++;

        }

        // return values as array
        return $result;
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