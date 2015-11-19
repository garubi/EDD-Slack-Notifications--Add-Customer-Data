<?php
/*
    Plugin Name: EDD Slack Notifications - Add customer data
    Plugin URL: https://github.com/garubi/EDD-Slack-Notifications--Add-Customer-Data
    Description: Extends the message sent to Slack adding the customer informations: Name, last name and email. Requires my fork of https://github.com/tubiz/edd-slack-notifications
    Version: 1.0
    Author: Stefano Garuti
    Author URI: http://wpmania.it
    License: GPL-2.0+
    License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

function edd_slack_customer_activation(){

    if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {

        // display notice
        add_action( 'admin_notices', 'edd_slack_customer_admin_notices' );

        return;
    }

}
add_action( 'admin_init', 'edd_slack_customer_activation' );


function edd_slack_customer_admin_notices(){

    if ( ! is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) ) {
        echo '<div class="error"><p>You must install & activate <a href="http://wordpress.org/plugins/easy-digital-downloads/" title="Easy Digital Downloads" target="_blank"><strong>Easy Digital Downloads</strong></a> to use <strong>Easy Digital Downloads - Slack Notifications</strong></p></div>';
    }

}

add_filter('tbz_edd_message','edd_slack_customer_extend_message',10,2);
function edd_slack_customer_extend_message($payment_id, $message){
	$payment_meta   = edd_get_payment_meta( $payment_id );
	$user_data = $payment_meta['user_info'];
	$message .= '*Customer:* '.$user_data['first_name'].' '.$user_data['last_name'].' '.$user_data['email']."\n";
	return $message;
}