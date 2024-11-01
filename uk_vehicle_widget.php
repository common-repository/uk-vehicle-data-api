<?php
if (!defined('ABSPATH'))exit;
class UKVD_uk_vehicle_plugin extends WP_Widget {
     
    function __construct() {
		parent::__construct(
			 
			// base ID of the plugin/widget
			'UKVD_uk_vehicle_plugin',
			 
			// name of the plugin/widget
			__('UK Vehicle Data Widget', 'UKVD_wpb_vehicle_plugin_uk' ),
			 
			// plugin options
			array (
				'description' => __( 'Widget for WordPress Pages which will return vehicle data to the end user.' )
			)
			 
		);
    }
    
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
        $endUserText = $instance['endUserText'];
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];

        // Physical Widget to follow
		echo __('
            <div>
                '.$endUserText.'
            </div>
            <br/>
            <form method="POST" action="'.esc_attr( get_option('UKVD_Widget_ActionLocation') ).'"
            
            <fieldset style="display:block;" class="ui-field-contain">
            
            <input type="text" id="UKVD_Vehicle_Registration" name="UKVD_Vehicle_Registration" placeholder="Registration" style="width:100%;"></input>
            <button type="submit" style="width:100%;">Search</button>
            
            </fieldset>
            </form>
            ', 'wpb_vehicle_plugin_uk' );
            echo $args['after_widget'];
        }

    

	public function UKVD_form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'UK Vehicle Data', 'UKVD_wpb_vehicle_plugin_uk' );
		}
        
        if ( isset( $instance[ 'endUserText' ] ) ) {
			$endUserText = $instance[ 'endUserText' ];
		}
		else {
			$endUserText = __( 'To find vehicle data, type a registration number in below and hit "Search" ', 'UKVD_wpb_vehicle_plugin_uk' );
		}
        
        
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            
            <br/>
            <br/>
            
            <label for="<?php echo $this->get_field_id( 'endUserText' ); ?>"><?php _e( 'End User Message:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'endUserText' ); ?>" name="<?php echo $this->get_field_name( 'endUserText' ); ?>" type="text" value="<?php echo esc_attr( $endUserText ); ?>">
		</p>
		<?php 
	}
	public function UKVD_update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['endUserText'] = ( ! empty( $new_instance['endUserText'] ) ) ? strip_tags( $new_instance['endUserText'] ) : '';
		return $instance;
	}
}


/*function to hook onto wordpress to register this plugin/widget*/
function UKVD_load_vehicle_widget() {
 
    register_widget( 'UKVD_uk_vehicle_plugin' );
 
}
//hook ('widgets_init') identified by WordPress
add_action( 'widgets_init', 'UKVD_load_vehicle_widget' );
?>