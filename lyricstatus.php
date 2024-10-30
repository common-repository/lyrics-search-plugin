<?php
/*
Plugin Name: Lyrics Search Plugin
Plugin URI: http://www.lyricstatus.com
Description: Adds a sidebar widget to search for song lyrics on <a href="http://lyricstatus.com/">LyricStatus.com</a>
Author: LyricStatus
Version: 1.0.0
Author URI: http://www.lyricstatus.com
*/

// Shortcode for putting it into pages or posts directly
// profile id is required. Won't work without it.

class LyricStatus_Widget extends WP_Widget {
	function LyricStatus_Widget() {
		$widget_ops = array('classname' => 'widget_'.strtolower("LyricStatus"), 'description' => __('Lyrics Search Plugin', ''));
		$this->WP_Widget(strtolower("LyricStatus"), __('LyricStatus', strtolower("LyricStatus")), $widget_ops);
	}
	function lyricstatus_shortcode() {

        $text = "<form action=\"http://www.lyricstatus.com/search\" id=\"searchform\" target=\"_blank\" onsubmit='document.getElementById(\"q\").value = document.getElementById(\"searchInput\").value + \" \";'>
      <input id=\"searchInput\"  type=\"text\" accesskey=\"f\" value=\"\" /><input type=\"submit\" id=\"fulltext\" class=\"searchButton\" value=\"Search\"  />
        <input type='hidden' name='q' id='q' value=''/>    
</form>
";

	return $text;
}
	function widget($args, $instance) {
		$options = get_option(strtolower("LyricStatus").'_options');
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<?php echo $this->lyricstatus_shortcode(); ?>
		<?php echo $after_widget; ?>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
		?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</label></p>
		<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("LyricStatus_Widget");'));
