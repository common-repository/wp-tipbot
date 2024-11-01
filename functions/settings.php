<?php 

add_action('admin_menu', 'ee_add_settings_page');
function ee_add_settings_page () {
    add_submenu_page( 'options-general.php', 
    __('WP TipBot','wp-tipbot'), 
    __('WP TipBot','wp-tipbot'), 
    'manage_options', 
    'wp-tipbot',
    'wp_tipbot_settings_page'); 
}


function wp_tipbot_settings_page () {

	$settings = get_option('wp_tipbot_settings', false);
	$settings = (	$settings != false) ? unserialize($settings) : [];

	if (!empty($_POST) && count($_POST) > 0) {

		if ( isset($_POST['size']) ){
			$settings['size'] = intval( $_POST['size'] );
		}

		if ( isset($_POST['amount']) ){
			$settings['amount'] = floatval( $_POST['amount'] );
		}

		if ( isset($_POST['receiver']) ){
			$settings['receiver'] = sanitize_text_field( $_POST['receiver'] );
		}

		if ( isset($_POST['network']) ){
			$settings['network'] = sanitize_text_field( $_POST['network'] );
		}

		if ( isset($_POST['label']) ){
			$settings['label'] = sanitize_text_field( $_POST['label'] );
		}

		if ( isset($_POST['labelpt']) ){
			$settings['labelpt'] = sanitize_text_field( $_POST['labelpt'] );
		}

		update_option( 'wp_tipbot_settings', serialize($settings) );

	}
	
	$size = !empty($settings['size']) ? $settings['size'] : 250;
	$amount = !empty($settings['amount']) ? $settings['amount'] : 1;
	$receiver = !empty($settings['receiver']) ? $settings['receiver'] : '';
	$network = !empty($settings['network']) ? $settings['network'] : 'twitter';
	$label = !empty($settings['label']) ? $settings['label'] : '';
	$labelpt = !empty($settings['labelpt']) ? $settings['labelpt'] : '';

	?>

	<div class="tipbot-container">

		<img style="display: block;margin: 20px auto;" src="<?php echo plugins_url( '../assets/images/WP-TipBot-logo.png', __FILE__ ); ?>" alt="">
		<h1 style="text-align: center;margin: 20px 0;"><?php _e('WP TipBot Details','wp-tipbot') ?></h1>

		<ul class="tipbot-tabs">
			<li class="active" data-activate-tab='tipbot-settings'><?php _e('Main settings','wp-tipbot');?> </li>

			<?php if ($receiver != '' && $network != '') { ?>
				<li data-activate-tab='tipbot-balance'><?php _e('Balance','wp-tipbot');?> </li>
			<?php } ?>

			<li data-activate-tab='tipbot-help'><?php _e('Shortcode','wp-tipbot');?> </li>
			<li data-activate-tab='tipbot-donations'><?php _e('Support','wp-tipbot');?> </li>
		</ul>


		<div class="tab-member tipbot-settings active">
			<?php _e('Please set your default values! Once filled, you can simply use the [wp-tipbot] shortcode.','wp-tipbot') ?>
			<form name="form-what-ever" method="post" action="">
				<!-- Size -->
				<p>
					<label for="wp-tipbot-size"><?php esc_html_e( 'Button size:', 'wp-tipbot' ); ?></label>
					<input class="widefat" id="wp-tipbot-size" name="size" type="number" min="0" value="<?php echo esc_attr( $size ); ?>" style="width:150px;"/> px (<?php _e('This will change the width of the button.','wp-tipbot') ?>)
				</p>
				
				<!-- Ammount -->
				<p>
					<label for="wp-tipbot-amount"><?php esc_html_e( 'Tips amount:', 'wp-tipbot' ); ?></label>
					<input class="widefat" id="wp-tipbot-amount" name="amount" type="text" value="<?php echo esc_attr($amount); ?>" step="0.1" style="width:150px;"/> XRP (<?php _e('The tip amount of XRP you want to receive.','wp-tipbot') ?>)
				</p>
				
				<!-- Account type -->
				<p>
					<label style="min-width: 200px" for="wp-tipbot-network"><?php esc_html_e( 'Network:', 'wp-tipbot' ); ?></label>
					<select name="network" id="wp-tipbot-network"  style="width:250px;">
						<option <?php if ($network=="twitter") echo 'selected' ?> value="twitter">Twitter</option>
						<option <?php if ($network=="reddit") echo 'selected' ?> value="reddit">reddit</option>
						<option <?php if ($network=="discord") echo 'selected' ?> value="discord">Discord</option>
					</select>
					(<?php echo sprintf(__('The network your XRP Tip Bot account is linked to. Don’t have a XRP Tip Bot account? Get one <a href="%s">here</a>.','wp-tipbot'),"https://www.xrptipbot.com/?login=do"); ?>)
				</p>

				<!-- Receiver -->
				<p>
					<label for="wp-tipbot-receiver"><?php esc_html_e( 'Receiver Username:', 'wp-tipbot' ); ?></label>
					<input class="widefat" id="wp-tipbot-receiver" name="receiver" type="text" value="<?php echo esc_attr($receiver); ?>"  style="width:250px;"/>  (<?php _e('Your username of the network which is linked to XRP Tip Bot.','wp-tipbot') ?>)
				</p>
				
				<!-- Button Label -->
				<p>
					<label style="min-width: 200px" for="wp-tipbot-label"><?php esc_html_e( 'Button label:', 'wp-tipbot' ); ?></label>
					<input class="widefat" id="wp-tipbot-label" name="label" type="text" value="<?php echo esc_attr($label); ?>"  style="width:250px;"/>  (<?php _e('The text which is shown on the button.','wp-tipbot') ?>)
				</p>
				
				<!-- Thank you message -->
				<p>
					<label style="min-width: 200px" for="wp-tipbot-labelpt"><?php esc_html_e( 'Thank you message:', 'wp-tipbot' ); ?></label>
					<input  style="width:250px;" class="widefat" id="wp-tipbot-labelpt" name="labelpt" type="text" value="<?php echo esc_attr($labelpt); ?>"/>  (<?php _e('The text which is shown on the button, once the user send you a tip.','wp-tipbot') ?>)
				</p>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'wp-tipbot' ); ?>">
				</p>
			</form>
		</div>
		

		<?php if ($receiver != '' && $network != '') { ?>

			<div class="tab-member tipbot-balance">
				<iframe style="width: 100%; min-height: 500px;height: auto;" src="https://www.xrptipbot.com/u:<?php echo $receiver ?>/n:<?php echo $network ?>" frameborder="0"></iframe>
			</div>

		<?php } ?>


		<div class="tab-member tipbot-help">
			<h2><?php _e('How to use the shortcode?','easyexam') ?></h2>
				<p><?php _e('Here is an example how to it:','wp-tipbot') ?></p>
				<p><pre><code>[wp-tipbot size="250" amount="0.5" receiver="WpTipbot" network="twitter" label="Tip me" labelpt="Thaaaanks"]</code></pre></p>
				<p>
					<?php _e('And here are the shortcode attributes that you can use:','wp-tipbot'); ?>	
					<table id="shortcode-details">
						<tbody>
							<tr>
								<td>[wp-tipbot]</td>
								<td><?php _e('Uses the values from the default settings.','wp-tipbot') ?></td>
							</tr>
							<tr>
								<td>[wp-tipbot <strong>size</strong>="250"]</td>
								<td><?php _e('This will change the width of the button in px.','wp-tipbot') ?></td>
							</tr>
							<tr>
								<td>[wp-tipbot <strong>amount</strong>="0.5"]</td>
								<td><?php _e('The tip amount of XRP you want to receive.','wp-tipbot') ?></td>
							</tr>
							<tr>
								<td>[wp-tipbot <strong>receiver</strong>="name"]</td>
								<td><?php _e('Your username of the network which is linked to XRP Tip Bot.','wp-tipbot') ?></td>
							</tr>
							<tr>
								<td>[wp-tipbot <strong>network</strong>="twitter"]</td>
								<td><?php echo sprintf(__('The network your XRP Tip Bot account is linked to. (Use: "twitter", "reddit" or "discord")<br><small>Don’t have a XRP Tip Bot account? Get one <a href="%s">here</a>.</small>','wp-tipbot'),"https://www.xrptipbot.com/?login=do") ?></td>
							</tr>
							<tr>
								<td>[wp-tipbot <strong>label</strong>="Tip"]</td>
								<td><?php _e('The text which is shown on the button.','wp-tipbot') ?></td>
							</tr>
							<tr>
								<td>[wp-tipbot <strong>labelpt</strong>="Thaaaanks"]</td>
								<td><?php _e('The text which is shown on the button, once the user send you a tip.','wp-tipbot') ?></td>
							</tr>
						</tbody>
					</table>
				</p>		
		</div>


		<div class="tab-member tipbot-donations">
			<p><?php echo sprintf(__('Tell us about your project and how the WP-Tipbot plugin helps to monetize your content. Sharing your story with us is a win-win - we will post it on our <a href="%s" target="_blank" rel="nofollow noopener">blog</a> and <a href="%s" target="_blank" rel="nofollow noopener">twitter</a> and you will get some extra attention from the community.','wp-tipbot'),"https://wp-tipbot.com/story","https://twitter.com/WpTipbot")?></p>

			<p><?php _e('And if you like our plugin, please consider sharing some tips with us','wp-tipbot') ?></p>

			<?php
			echo do_shortcode( '[wp-tipbot size="250" amount="0.5" receiver="WpTipbot" network="twitter" label="Tip me" labelpt="Thaaaanks"]' );
			?>

			<p><?php echo sprintf(__('For bugs and other support questions - please use the <a href="%s">WordPress Support forum</a>.','wp-tipbot'),'https://wordpress.org/support/plugin/wp-tipbot'); ?></p>
			<p><?php echo sprintf(__('Find us on <a href="%s" target="_blank" rel="nofollow noopener">twitter (@WpTipbot)</a> or check <a href="%s" target="_blank" rel="nofollow noopener">our website</a>.','wp-tipbot'),"https://twitter.com/WpTipbot","https://wp-tipbot.com")?></p>
		</div>


	</div>

	<script>

		jQuery( function($) {

			// controlls for the tabs
			$('.tipbot-tabs li').on('click', function () {
				$('.tipbot-tabs li.active').removeClass('active');
				$('.tab-member.active').removeClass('active');
				$(this).addClass('active');
				var showTab = $(this).data('activate-tab');
				$('.'+showTab).addClass('active');
			});

			// strip @ sign form any string entered in the receiver field
			$('#wp-tipbot-receiver').on('blur',function() {

				var value = $(this).val().replace(/@/g,'');
				$(this).val(value);

			});

		});

	</script>

	<style>
		.tipbot-container {
			width:80%;
			margin: 0 auto;
			font-size: 1rem;
		}
		p,label {
			font-size: 1rem;
		}
		.tipbot-settings label {
			display: inline-block;
			min-width: 200px;
		}
		.tipbot-tabs {
		  display: flex;
		  flex-wrap: wrap;
		  border-bottom: 1px solid #ccc;
		}

		.tipbot-tabs li {
		  border: 1px solid #ccc;
		  border-bottom: none;
		  margin: 10px 15px 0 9px;
		  padding: 5px 10px;
		  font-size: 1rem;
		  cursor: pointer;
		}
		.tipbot-tabs .active {
		    background: #fff;
		}
		.tab-member{
			display: none;
		}

		.tab-member.active{
			display: block;
		}

		#shortcode-details {
			border-collapse: collapse;
		}

		#shortcode-details td {
			border: 1px solid #ccc;
			padding: 7px 9px;
		}
	</style>
	<?php

}