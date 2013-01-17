<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('filterPost'))
{
    function    filterPost($string)
    {
        // for syntax highlighting
        $start_pos = strpos($string, '[code]');
        $end_pos = (strpos($string, '[/code]') + 7) - $start_pos;
        $is_start_code = strstr($string, '[code]');
        $is_end_code = strstr($string, '[/code]');
        $open_highlight = '<div class="highlight"><pre class="code">';
        $close_highlight = '</pre></div>';
        
        if ($is_start_code && $is_end_code) {
            //get string inside the [code][/code] block
            $code_str = substr($string, $start_pos, $end_pos);
            //$code_str = htmlspecialchars($code_str);
            $code_str = str_replace("[code]\n", '[code]', $code_str);
            $code_str = str_replace("[code]", $open_highlight, $code_str); 
            $code_str = str_replace("[/code]", $close_highlight, $code_str);
            
            //get string before [code]
            $tmp_str1 = explode('[code]', $string); 
            $str_bef_code = strip_tags($tmp_str1['0']);
            $str_bef_code = str_replace("\n", '<br>', $str_bef_code);
            
            //get string after [code]
            $tmp_str2 = explode('[/code]', $string); 
            $str_after_code = strip_tags($tmp_str2['1']);
            $str_after_code = str_replace("\n", '<br>', $str_after_code);
            $string = $str_bef_code . $code_str . $str_after_code;

            return $string;
        }

        $string = htmlspecialchars($string);
        $string = str_replace("\n", '<br>', $string);

        return $string;
    }
    
    //returns Dec 04, 2012 12:12 PM date format
    function filterPostDate($timestamp)
    {
        return date("m-d-y g:h a", strtotime($timestamp));
    }
}