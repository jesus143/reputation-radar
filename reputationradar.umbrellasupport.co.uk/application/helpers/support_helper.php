<?php




if(!function_exists('print_r_pre')) {
    function print_r_pre($data)
    {
        print "<pre>";
        print_r($data);
        print "</pre>";
    }
}