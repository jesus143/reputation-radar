<?php

$originalSite = 'https://uk.trustpilot.com/review/www.parispass.com';

$messageDetails = '/reviews/586d3b750dc2f60984532b7f';

$originalSiteArr = explode(".com", $originalSite);

$originalSiteNow = $originalSiteArr[0] . '.com';

$source_url = $originalSiteNow . $messageDetails;

print " " . $source_url;















exit;
$keyword = 'hello world';
$keywordArr = explode(' ', $keyword);
$newKeyword = '';
$counter = 0;
foreach($keywordArr as $keyword) {
    $newKeyword .=     '+'.$keyword;
    if($counter < count($keywordArr)-1) {
        $newKeyword .= '-';
    }
    $counter++;
}
print $newKeyword ;
