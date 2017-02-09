<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Scraper Library
 *
 * A library to provide basic XPath scraping support
 *
 * @package        CodeIgniter
 * @author        Kyle J. Dye | www.kyledye.com | kyle@kyledye.com
 * @copyright    Copyright (c) 2010, Kyle J. Dye.
 * @license        http://codeigniter.com/user_guide/license.html
 * @link            http://kyledye.com
 * @version        Version 0.1
 */
class NiceTesting {

    function __construct() {
        $this->CI =& get_instance();
    }

    public function testing() {
        print " alright, this is new library created";
    }

}