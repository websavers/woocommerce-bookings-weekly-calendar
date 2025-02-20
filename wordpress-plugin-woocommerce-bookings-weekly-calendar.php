<?php
/*
Plugin Name: WooCommerce Bookings Weekly Calendar
Version: 1.0b
Description: Provides a weekly calendar view for WooCommerce Bookings.
Author: Websavers Inc.
Forked from Author: Nick Breen
Plugin URI: https://github.com/websavers/woocommerce-bookings-weekly-calendar
Text Domain: woocommerce-bookings-weekly-calendar
Domain Path: /languages
*/

// See /wp-content/plugins/woocommerce-bookings/
// See includes/admin/class-wc-bookings-menus.php:109
add_action('admin_menu', function () {
    $calendar_page = add_submenu_page(
        'edit.php?post_type=wc_booking',
        __( 'Weekly Calendar', 'woocommerce-bookings-weekly-calendar' ),
        __( 'Weekly Calendar', 'woocommerce-bookings-weekly-calendar' ),
        'manage_bookings',
        'booking_calendar_weekly',
        function () {
            require_once( __DIR__ . '/includes/admin/class-wc-bookings-calendar-weekly.php' );
    		$page = new WC_Bookings_Calendar_Weekly();
    		$page->output();
        }
    );
}, 49 );

add_filter('woocommerce_screen_ids', function ($ids) {
    return array_merge( $ids, array(
        'wc_booking_page_booking_calendar_weekly',
    ) );
});

/**
 * Add the driver bookings end points
 */

add_action('init', function () {
    // TODO option
    add_rewrite_endpoint('bookings-week-view', EP_ROOT|EP_PAGES);
});

add_filter('woocommerce_account_menu_items', function ($items) {
    //if (current_user_can('driver'))
        // TODO option
        $items['bookings-week-view'] = __('Bookings Week View', 'woocommerce-bookings-weekly-calendar');
    return $items;
});

add_filter('woocommerce_endpoint_bookings-week-view_title', function ($items) {
    return __('Bookings Week View', 'woocommerce-bookings-weekly-calendar');
});

add_filter('pods_api_get_table_info_default_post_status', function ($stati, $post_type, $info, $object_type, $object, $name, $pod, $field) {
    return $stati = $field['options']['pick_post_status'] ?? $stati;
}, 10, 8);

add_action('woocommerce_account_bookings-week-view_endpoint', function ($value) {
    // TODO option
    $user = pods('user', array(
        'where' => sprintf('user.ID = %d', get_current_user_id())
    ));

    while ($user->fetch()) {

        printf('<h1>%s&apos;s Bookings</h1>', $user->display('post_title'));

        echo '<code style="color: initial">';
        echo '</code>';
    }
});
