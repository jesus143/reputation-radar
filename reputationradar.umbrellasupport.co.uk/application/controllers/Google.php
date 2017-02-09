<?php
error_reporting(0);

class Google extends  CI_Controller
{

    protected $companyUrl = '';

    public function Index()
    {
        $this->companyUrl = 'https://www.google.com.ph/search?num=50&q=obejero';
        // $trustPilotData = $this->getReviewCentreComments();
        $this->getGoogleData();
    }


    public function getGoogleData()
    {
        $this->load->library('simple_html_dom');

        $html = file_get_html($this->companyUrl);

        $i=0;



        print "<pre>";
        foreach($html->find('div.g') as $search) {

//            print "<pre>";
//            print_r($search);
//            print"</pre>";

            $i++;
 
                $title = $search->find('a', 0);
                $link = $search->find('cite', 0);


                $description = $search->find('span.st', 0);


            print "  $i ";

            if(!empty($title)) {
                print "title text = " . $title->text();
            }

            if(!empty($link)) {
                print "title text = " . $link->text();
            }

            print "<br>";




//            print_r($title);


//            $titleArray = (array)$title;

//
//
//            $titleText = $title->text();
//
//
//
//                print "$i ";
//
//                print " title text " . $titleText . '<br>';
//




//
//
//                if(strpos($title->text(), 'Images') <= -1) {
//
//                    print "$i<br>";
//
//
//                    if (!empty($link1->text())) {
//                        print " " . $link1->text();
//                    }
//
//                    if (!empty($link2->text())) {
//                        print " " . $link2->text();
//                    }
////
//                    if (!empty($link3->text())) {
//                        print " " . $link3->text();
//                    }
//
//                    print "<br><br><br>";
//                }



//            }


//            $link12 = (!empty($link1->text() ) ) ? $link1->text() : null;
//
//            print " " . $link12 ;

//            exit;


//            print "<br>" . $i .'  '. $link1->text()  . ' ' .$link2->text() . ' <br><b>' . $link3->text() . '</b>' ;



            //            if($i  >1) {
            //                break;
            //            }


//            break;



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