<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
 
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/adminoptions/' );
	require_once get_template_directory() . '/framework/adminoptions/options-framework.php';
}

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	
	$shortname = DESSKY_SHORTNAME;
	
	$optLogotype 	= array(
		'imagelogo' 	=> __('Image logo','dessky'),
		'textlogo' 		=> __('Text-based logo','dessky')
		 );
	
	$optArrSlider 	= array(
		'ASC' => 'Ascending',
		'DESC' => 'Descending'
		 );
	
	$optSliderEffect 	= array(
			'fade'=>'Fade',
			'slide'=>'Slide'
   			 );

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll'
	);
	             
	$optBackgroundStyle = array(
		'repeat' => "Repeat",
		'repeat-x' => "Repeat Horizontal",
		'repeat-y' => "Repeat Vertical",
		'no-repeat' => "No Repeat",
		'fixed' => "Fixed"
		);
		
	$optBackgroundPosition = array(
		'left' => "Left",
		'center' => "Center",
		'right' => "Right",
		'top left' => "Top",
		'top center' => "Top Center",
		'top right' => "Top Right",
		'bottom left' => "Bottom",
		'bottom center' => "Bottom Center",
		'bottom right' => "Bottom Right"
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	$options_categories["allcategories"] =__('All Categories','dessky');
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/assets/images/';

	$options = array();

	$options[] = array( 'name' => __('General', 'dessky'),
		'type' => 'heading');
	
	$options[] = array( 'name' => __('Layout Settings', 'dessky'),
		'type' => 'headingchild');
	
	$options[] = array( 'name' => __('Sidebar Position', 'dessky'),
		'desc' => __('Select sidebar position. Default sidebar is right.', 'dessky'),
		'id' => $shortname."_sidebar_position",
		'std' => 'right',
		'type' => 'images',
		'options' => array(
			'left' => $imagepath . '2cl.png',
			'right' => $imagepath . '2cr.png')
	);
	
	$options[] = array( 'name' => __(' ', 'dessky'),
		'type' => 'separator');
	
	$options[] = array( 'name' => __('Header Settings', 'dessky'),
		'type' => 'headingchild');
	
	$options[] = array( 'name' => __('Logo Type', 'dessky'),
		'desc' => __('If text-based logo is activated, enter the sitename and tagline in the fields below.', 'dessky'),
		'id' => $shortname."_logo_type",
		'std' => 'imagelogo',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $optLogotype);
	
	$options[] = array( 'name' => __('Site name', 'dessky'),
		'desc' => __('Put your sitename in here.', 'dessky'),
		'id' => $shortname."_site_name",
		'std' => '',
		'type' => 'text');
	
	$options[] = array( 'name' => __('Tagline', 'dessky'),
		'desc' => __('Put your tagline in here.', 'dessky'),
		'id' => $shortname."_tagline",
		'std' => '',
		'type' => 'text');
	
	$options[] = array( 'name' => __('Logo Image', 'dessky'),
		'desc' => __('If image logo is activated, upload the logo image.', 'dessky'),
		'id' => $shortname."_logo_image",
		'type' => 'upload');
	
	$options[] = array( 'name' => __('Favicon', 'dessky'),
		'desc' => __('Upload the favicon image.', 'dessky'),
		'id' => $shortname."_favicon",
		'type' => 'upload');
	
	$options[] = array( 'name' => __('Footer Settings', 'dessky'),
		'type' => 'headingchild');
	
	$options[] = array( 'name' => __('Footer Text', 'dessky'),
		'desc' => __('You can use html tag in here.', 'dessky'),
		'id' => $shortname."_footer",
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array( 'name' => __('Tracking Code', 'dessky'),
		'desc' => __('Enter your tracking code here.', 'dessky'),
		'id' => $shortname."_google",
		'std' => '',
		'type' => 'textarea');
		
		
	$options[] = array( 'name' => __('Style', 'dessky'),
		'type' => 'heading');
		
	$options[] = array( 'name' => __('Background', 'dessky'),
		'type' => 'headingchild');
		
	$options[] = array( 'name' =>  __('Body Background', 'dessky'),
		'desc' => __('Change the background CSS.', 'dessky'),
		'id' => $shortname."_body_background",
		'std' => $background_defaults,
		'type' => 'background');
	
	$options[] = array( 'name' => __('Social', 'dessky'),
		'type' => 'heading');
		
	
	$options[] = array( 'name' => __('Social Icon', 'dessky'),
		'type' => 'headingchild');
	
	$options[] = array( 'name' => __('Twitter URL', 'dessky'),
		'desc' => __('Please input your twitter URL. Example : http://www.twitter.com/your-username', 'dessky'),
		'id' => $shortname."_twitter_link",
		'std' => 'http://www.twitter.com/your-username',
		'type' => 'text');
	
	$options[] = array( 'name' => __('Facebook URL', 'dessky'),
		'desc' => __('Please input your facebook URL. Example : http://www.facebook.com/your-username', 'dessky'),
		'id' => $shortname."_facebook_link",
		'std' => 'http://www.facebook.com/your-username',
		'type' => 'text');
	
	$options[] = array( 'name' => __('Google+ URL', 'dessky'),
		'desc' => __('Please input your google+ URL. Example : https://plus.google.com/u/0/110149804655622272330/posts', 'dessky'),
		'id' => $shortname."_googleplus_link",
		'std' => 'https://plus.google.com/u/0/110149804655622272330/posts',
		'type' => 'text');
	
	$options[] = array( 'name' => __('Pinterest URL', 'dessky'),
		'desc' => __('Please input your pinterest URL. Example : http://pinterest.com/your-username', 'dessky'),
		'id' => $shortname."_pinterest_link",
		'std' => 'http://pinterest.com/your-username',
		'type' => 'text');
	
	$options[] = array( 'name' => __('Social Icon Custom HTML', 'dessky'),
		'desc' => __('If you want to put another Social Network URL, please input the HTML code in here. <br />For Example : &lt;li&gt;&lt;a href=&quot;http://yoururl.com/&quot;&gt;&lt;span class=&quot;icon-img&quot; style=&quot;background-image:url(http://your-icon-url.com/img.gif)&quot;&gt;&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;', 'dessky'),
		'id' => $shortname."_socialicon_custom",
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array( 'name' => __('Enable Social Icon', 'dessky'),
		'desc' => __('Select this checkbox to enable social icon.', 'dessky'),
		'id' => $shortname."_enable_socialicon",
		'std' => '0',
		'type' => 'checkbox');
		
	
	$options[] = array( 'name' => __('Slider', 'dessky'),
		'type' => 'heading');
		
		
	$options[] = array( 'name' => __('Disable Slider', 'dessky'),
		'desc' => __('Select this checkbox to disable slider.', 'dessky'),
		'id' => $shortname."_disable_slider",
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array( 'name' => __('Arrange Slider Post', 'dessky'),
		'desc' => __('Select the order for your slider. the default is Ascending', 'dessky'),
		'id' => $shortname."_slider_arrange",
		'std' => 'ASC',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $optArrSlider);
	
	$options[] = array( 'name' => __('Slider Effect', 'dessky'),
		'desc' => __('Please select transition effect. The default is fade', 'dessky'),
		'id' => $shortname."_slider_effect",
		'std' => 'fade',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $optSliderEffect);
	
	$options[] = array( 'name' => __('Slider Interval', 'dessky'),
		'desc' => __('Please enter number for slider interval. Default is 600', 'dessky'),
		'id' => $shortname."_slider_interval",
		'std' => '600',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array( 'name' => __('Disable Slider Text', 'dessky'),
		'desc' => __('Select this checkbox to disable the slider text.', 'dessky'),
		'id' => $shortname."_slider_disable_text",
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array( 'name' => __('Disable Slider Navigation', 'dessky'),
		'desc' => __('Select this checkbox to disable navigation.', 'dessky'),
		'id' => $shortname."_slider_disable_nav",
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array( 'name' => __('Blog', 'dessky'),
		'type' => 'heading');
		
	$options[] = array( 'name' => __('Blog Category', 'dessky'),
		'desc' => __('The value is category for display in blog page.', 'dessky'),
		'id' => $shortname."_blog_category",
		'std' => 'blog',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $options_categories);
		
		
	$options[] = array( 'name' => __('Disable Title', 'dessky'),
		'desc' => __('Select this checkbox to disable title.', 'dessky'),
		'id' => $shortname."_pf_disable_title",
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array( 'name' => __('Disable Short Description', 'dessky'),
		'desc' => __('Select this checkbox to disable short description.', 'dessky'),
		'id' => $shortname."_pf_disable_desc",
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array( 'name' => __('Length Character', 'dessky'),
		'desc' => __('Length description character', 'dessky'),
		'id' => $shortname."_pf_lengthchar",
		'std' => '25',
		'class' => 'mini',
		'type' => 'text');
		
	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}

});
</script>

<?php
}