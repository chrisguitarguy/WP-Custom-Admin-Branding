<?php

require_once( trailingslashit( get_stylesheet_directory() ) . 'branding.php' );

new Custom_Admin_Branding( array( 
    'login_url'       => 'http://example.com', 
    'login_image'     => 'http://placebear.com/273/63',
    'login_title'     => 'This is a title',
    'designer_url'    => 'http://christopherdavis.me',
    'designer_anchor' => 'Christopher Davis',
    'favicon_url'     => 'http://placebear.com/16/16'
) );

