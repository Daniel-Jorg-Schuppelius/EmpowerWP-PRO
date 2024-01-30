<?php

add_filter( 'mesmerize_notifications_template_slug', function () {
    return "empowerwp-pro";
}, 100 );

add_filter( 'mesmerize_notifications_stylesheet_slug', function () {
    return "empowerwp-pro";
}, 100 );

function empower_pro_first_activation_stylesheet( $stylesheet ) {
    $stylesheet = "empowerwp";

    return $stylesheet;
}

add_filter( 'mesmerize_pro_first_activation_stylesheet', 'empower_pro_first_activation_stylesheet' );

empower_require( "pro/customizer/customizer.php" );

function empower_footer_content_copyright_text_default() {
    return __( '&copy; {year} {blogname}. Built using WordPress and <a rel="nofollow" href="#">EmpowerWP Theme</a>.', 'empowerwp' );
}

add_filter( 'mesmerize_footer_content_copyright_text_default', 'empower_footer_content_copyright_text_default' );

function empower_pro_update_check_params( $args ) {

    $args = array_merge( $args,
        array(
            'product_id'   => 'empowerwp-pro',
            'product_name' => 'EmpowerWP PRO',
            'text_domain'  => 'empowerwp-pro',
        )
    );

    return $args;
}

add_filter( 'mesmerize_pro_update_check_params', 'empower_pro_update_check_params' );

add_filter( 'extendthemes_renew_purchase_url', function ( $url ) {
    $url = 'https://extendthemes.com/go/empower-purchase-renew';
    return $url;
} );
