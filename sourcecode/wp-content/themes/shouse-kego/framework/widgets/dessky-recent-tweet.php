<?php
// *********** DesskyRecent Tweet widget ***********
class DESSKY_RecentTweetWidget extends WP_Widget {
    /** constructor */

	function DESSKY_RecentTweetWidget() {
		$widget_ops = array('classname' => 'widget_dessky_recent_tweet', 'description' => __('Dessky -  Recent Tweet','dessky') );
		$this->WP_Widget('dessky-recent-tweet', __('Dessky -  Recent Tweet','dessky'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Dessky Recent Tweet','dessky') : $instance['title']);		
		$username = apply_filters('widget_username', $instance['username']);
		global $wp_query;
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
				<?php if($username) echo '<div title="'.$username.'" id="userandquery" class="query"></div>'; ?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] = (isset($instance['title']))? $instance['title'] : "";
		$instance['username'] = (isset($instance['username']))? $instance['username'] : "";
					
        $title = esc_attr($instance['title']);
		$username = esc_attr($instance['username']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dessky'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>            
            
            <p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', 'dessky'); ?> 
			
			<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></label></p>
        <?php 
    }

} // class  Widget
?>