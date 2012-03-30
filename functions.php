<?php
// require the branding file
require_once( trailingslashit( get_stylesheet_directory() ) . 'branding.php' );

// Create a new instance of the Custom_Admin_Branding class and pass in your args
new Custom_Admin_Branding( array( 
    'login_url'       => 'http://example.com', 
    'login_image'     => 'http://placebear.com/400/100',
    'login_title'     => 'This is a title',
    'login_height'    => '100px',
    'login_width'     => '400px',
    'designer_url'    => 'http://christopherdavis.me',
    'designer_anchor' => 'Christopher Davis',
    'favicon_url'     => 'http://placebear.com/16/16',
    'remove_wp'       => true
) );

