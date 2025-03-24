<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('pagination_helper')) {
    function pagination_helper($base_url, $total_rows, $per_page = 25) {
        $CI =& get_instance();
        
        $config = [
            'base_url' => $base_url,
            'per_page' => $per_page,
            'total_rows' => $total_rows,
            'uri_segment' => 3,
            
            // Pagination Styling
            'full_tag_open' => '<ul class="pagination justify-content-end">',
            'full_tag_close' => '</ul>',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close' => '</a></li>',
            
            // Link Styling
            'attributes' => ['class' => 'page-link'],
            'first_link' => '&laquo;',
            'last_link' => '&raquo;',
            'next_link' => 'Next',
            'prev_link' => 'Previous',
            
            // Numbers Config
            'use_page_numbers' => TRUE,
            'display_pages' => TRUE,
            'num_links' => 5
        ];

        $CI->pagination->initialize($config);
        return $CI->pagination->create_links();
    }
}
?>