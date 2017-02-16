<?php




if(!function_exists('print_r_pre')) {
    function print_r_pre($data)
    {
        print "<pre>";
        print_r($data);
        print "</pre>";
    }
}

if(!function_exists('change_long_space_to_sing_space')) {
    function change_long_space_to_sing_space($str)
    {
        return preg_replace('!\s+!', ' ', $str);
    }
}

