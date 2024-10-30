<?php
/**
 * convert URL to ID 
 * */
function bht_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
    return $attachment[0]; 
}

/**
* for limit word
* */
function bht_limit_words($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if(count($words) > $word_limit) {
        if(count($words) > $word_limit) {
            array_pop($words);
            return implode(' ', $words).'...';
        }
    } else {  
        return $string;
    }
}
