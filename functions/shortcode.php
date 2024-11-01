<?php

// [wp-tipbot size="200" amount="0.5" receiver="alordiel" network="reddit" label="Tip me" labelpt="Thaaaanks"]
add_shortcode( 'wp-tipbot', 'wp_tipbot_shortcode' );
function wp_tipbot_shortcode( $atts ) {
	
	$sc_atts = shortcode_atts( array(
		'title' => esc_html__( 'WP TIPBOT', 'wp-tipbot' ),
		'amount' => '',
		'network' => '',
		'receiver' => '',
		'label' => '',
		'size' => '',
		'labelpt' => '',
	), $atts );

	// get the shortcode attributes
	$amount 	= !empty( $sc_atts['amount'] ) ? $sc_atts['amount'] : '';
	$size 		= !empty( $sc_atts['size'] ) ? $sc_atts['size'] : '';
	$receiver = !empty( $sc_atts['receiver'] ) ? $sc_atts['receiver'] : '';
	$network 	= !empty( $sc_atts['network'] ) ? $sc_atts['network'] : '';
	$label 		= !empty( $sc_atts['label'] ) ? "label='{$sc_atts['label']}'"  : '';
	$labelpt 	= !empty( $sc_atts['labelpt'] ) ? "labelpt='{$sc_atts['labelpt']}'"  : '';

	// get the settings for the plugin
	$settings = get_option('wp_tipbot_settings', false);
	$settings = (	$settings != false) ? unserialize($settings) : [];

	// check for pre-default values from the settings page
	if ( $size == '' ) {

		$size = !empty($settings['size']) ? $settings['size'] : 250;

	}

	if ( $amount == '' ) {

		$amount = !empty($settings['amount']) ? $settings['amount'] : 1;

	}

	if ( $receiver == '' ) {

		$receiver = !empty($settings['receiver']) ? $settings['receiver'] : '';

	}

	if ($network == '') {

		$network = !empty($settings['network']) ? $settings['network'] : 'twitter';

	}

	if ($label == '' ) {

		$label = !empty($settings['label']) ?  "label='{$settings['label']}'" : '';
	}

	if ($labelpt == '') {

		$labelpt = !empty($settings['labelpt']) ? "labelpt='{$settings['labelpt']}'" : '';

	}

 	
	// check if any receiver
	if ($receiver == '') {

		return '';

	}

	// build the shortcode
	$output = "<div class='wp-tipbot-container'>
		<a
			amount='".$amount."'
			size='".$size."'
			to='".$receiver."'
			network='".$network."'
			href='https://www.xrptipbot.com'
			target='_blank' 
			$label 
			$labelpt>
		</a>
	</div>
	<script async src='https://www.xrptipbot.com/static/donate/tipper.js' charset='utf-8'></script>";

	return $output;

}
