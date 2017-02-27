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

if(!function_exists('isDomainAvailible')) {
    function isDomainAvailible($domain)
    {
           //check, if a valid url is provided
           if(!filter_var($domain, FILTER_VALIDATE_URL))
           {
                   return false;
           }

           //initialize curl
           $curlInit = curl_init($domain);
           curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
           curl_setopt($curlInit,CURLOPT_HEADER,true);
           curl_setopt($curlInit,CURLOPT_NOBODY,true);
           curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

           //get answer
           $response = curl_exec($curlInit);

           curl_close($curlInit);

           if ($response) return true;

           return false;
       }
    }