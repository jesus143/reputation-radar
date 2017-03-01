<?php
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