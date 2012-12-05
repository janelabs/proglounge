<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('filterPost'))
{
    function filterPost($string)
    {
        $open_highlight = '<div class="highlight"><pre class="code">';
        $close_highlight = '</pre></div>';
        
        $string = strip_tags($string); //remove html tags
                
        //for syntax highlighting
        $string = str_replace("[code]\n", '[code]', $string);
        $string = str_replace("[code]", $open_highlight, $string); 
        $string = str_replace("[/code]", $close_highlight, $string);
        
        return $string;
    }
    
    //returns Dec 04, 2012 12:12 PM date format
    function filterPostDate($timestamp)
    {
        return date("M d, Y g:h a", strtotime($timestamp));
    }
}