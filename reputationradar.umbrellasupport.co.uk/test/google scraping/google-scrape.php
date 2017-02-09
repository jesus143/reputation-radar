<?php

require('simple_html_dom.php');


/*
// Create DOM from URL or file
$html = file_get_html('https://www.youtube.com/feed/trending');

    // creating an array of elements
    $videos = [];

    // Find top ten videos
    $i = 1;
    foreach ($html->find('li.expanded-shelf-content-item-wrapper') as $video) {
        if ($i > 10) {
            break;
        }

        // Find item link element
        $videoDetails = $video->find('a.yt-uix-tile-link', 0);


        // get title attribute
        $videoTitle = $videoDetails->title;

        // get href attribute
        $videoUrl = 'https://youtube.com' . $videoDetails->href;

        // push to a list of videos
        $videos[] = [
            'title' => $videoTitle,
            'url' => $videoUrl
        ];

        $i++;
    }

    print "<pre>";
    print_r($videos);
    print "</pre>";

*/

/*
$html = file_get_html('https://www.youtube.com/feed/trending');

$i=0;
foreach ($html->find('li.expanded-shelf-content-item-wrapper') as $video) {
    $videoDetails = $video->find('a.yt-uix-tile-link', 0);
    print " title " .  $videoDetails->text() . '<br>';
    $i++;
    if($i>5) {
        break;
    }
}


*/



$html = file_get_html('https://www.google.com.ph/search?num=10&site=&q=jesus+erwin+suarez');

$i=0;

foreach($html->find('div.g') as $search) {

    $i++;
    $link1 = $search->find('a', 0);

    $link2 = $search->find('cite', 0);

    print "<br>" . $i .'  '. $link1  . ' ' .$link2->text() ;

}





