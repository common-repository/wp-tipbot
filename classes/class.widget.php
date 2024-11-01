<?php
class WP_TIPBOT_Widget extends WP_Widget {

	protected $defaults;

	public function __construct() {

		parent::__construct(
			'wp_tipbot',
			esc_html__('WP Tip Bot', 'wp-tipbot' ),
			array(
				'classname'   => 'wp-tipbot',
				'description' => __( 'Displays a XRP TIP BOT widget.', 'wp-tipbot' ),
			)
		);

		$this->defaults = array(
			'title' => esc_html__( 'WP TIPBOT', 'wp-tipbot' ),
			'amount' => 1,
			'network' => 'twitter',
			'receiver' => '',
			'label' => '',
			'size' => '',
			'labelpt' => '',
		);
	}

	public function widget( $args, $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		if ( $instance['title'] ) {

			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];

		}

	?>
		<!-- embed snipped code from : https://www.xrptipbot.com/account/embed  -->
		<a
			amount="<?php echo $instance['amount']; ?>" 
			size="<?php echo $instance['size']; ?>" 
			to="<?php echo $instance['receiver']; ?>" 
			network="<?php echo $instance['network']; ?>" 
			href="https://www.xrptipbot.com" 
			label="<?php echo $instance['label']; ?>"
			labelpt="<?php echo $instance['labelpt']; ?>"
			target="_blank">
		</a>
		<script async src="https://www.xrptipbot.com/static/donate/tipper.js" charset="utf-8"></script>

	<?php

		echo $args['after_widget'];

	}

	
	public function update( $new_instance, $old_instance ) {

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['size'] = intval( $new_instance['size'] );
		$instance['amount'] = ( 0 != $new_instance['amount'] ) ? (float) $new_instance['amount'] : 1;
		$instance['receiver'] = sanitize_text_field( $new_instance['receiver'] );
		$instance['label'] = sanitize_text_field( $new_instance['label'] );
		$instance['labelpt'] = sanitize_text_field( $new_instance['labelpt'] );

		return $instance;

	}


	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$size = $instance['size'] != 0 ? $instance['size'] : 250;

		?>

		<!-- Title -->
		<p>
			<label for="wp-tipbot-title"><?php esc_html_e( 'Title:', 'wp-tipbot' ); ?></label>
			<input class="widefat" id="wp-tipbot-title" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>

		<!-- Size -->
		<p>
			<label for="wp-tipbot-size"><?php esc_html_e( 'Button size:', 'wp-tipbot' ); ?></label>
			<input class="widefat" id="wp-tipbot-size" name="<?php echo $this->get_field_name( 'size' ); ?>" type="number" min="0" value="<?php echo esc_attr( $size ); ?>" style="width:150px;"/> px.
		</p>
		
		<!-- Ammount -->
		<p>
			<label for="wp-tipbot-amount"><?php esc_html_e( 'Tips amount:', 'wp-tipbot' ); ?></label>
			<input class="widefat" id="wp-tipbot-amount" name="<?php echo $this->get_field_name( 'amount' ); ?>" type="text" value="<?php echo esc_attr( $instance['amount'] ); ?>" step="0.1" style="width:150px;"/> XRP
		</p>
		
		<!-- Account type -->
		<p>
			<label for="wp-tipbot-network"><?php esc_html_e( 'Network:', 'wp-tipbot' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'network' ); ?>" id="wp-tipbot-network">
				<option <?php if ($instance['network']=="twitter") echo 'selected' ?> value="twitter">Twitter</option>
				<option <?php if ($instance['network']=="reddit") echo 'selected' ?> value="reddit">reddit</option>
				<option <?php if ($instance['network']=="discord") echo 'selected' ?> value="discord">Discord</option>
			</select>
		</p>

		<!-- Receiver -->
		<p>
			<label for="wp-tipbot-receiver"><?php esc_html_e( 'Receiver Username:', 'wp-tipbot' ); ?></label>
			<input class="widefat" id="wp-tipbot-receiver" name="<?php echo $this->get_field_name( 'receiver' ); ?>" type="text" value="<?php echo esc_attr( $instance['receiver'] ); ?>"/>
		</p>
		
		<!-- Button Label -->
		<p>
			<label for="wp-tipbot-label"><?php esc_html_e( 'Button label:', 'wp-tipbot' ); ?></label>
			<input class="widefat" id="wp-tipbot-label" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo esc_attr( $instance['label'] ); ?>"/>
		</p>
		
		<!-- Thank you message -->
		<p>
			<label for="wp-tipbot-labelpt"><?php esc_html_e( 'Thank you message:', 'wp-tipbot' ); ?></label>
			<input class="widefat" id="wp-tipbot-labelpt" name="<?php echo $this->get_field_name( 'labelpt' ); ?>" type="text" value="<?php echo esc_attr( $instance['labelpt'] ); ?>"/>
		</p>

	<?php
	}
}
