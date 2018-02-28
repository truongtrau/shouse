<?php
$prefix = 'dessky_';

$optsidebar = array(
	"page-sidebar" => "Page Sidebar", 
	"post-sidebar" => "Post Sidebar"
);
$textarrayval = get_option('dessky_sidebar');
	if(is_array($textarrayval)){
		
		foreach($textarrayval as $ids => $val){
			$optsidebar[$ids] = $val;
		}
		
	}

// Create meta box slider
$meta_boxes = array();

$meta_boxes[] = array(
	'id' => 'page-sidebar-meta-box',
	'title' => __('Page Sidebar Option','dessky'),
	'page' => 'page',
	'showbox' => 'page_sidebar_show_box',
	'context' => 'side',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Registered Sidebar','dessky'),
			'desc' => '<em>'.__('Please choose the sidebar for this page','dessky').'</em>',
			'options' => $optsidebar,
			'id' => $prefix.'sidebar',
			'type' => 'select',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'post-sidebar-meta-box',
	'title' => __('Post Sidebar Option','dessky'),
	'page' => 'post',
	'showbox' => 'post_sidebar_show_box',
	'context' => 'side',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Registered Sidebar','dessky'),
			'desc' => '<em>'.__('Please choose the sidebar for this post','dessky').'</em>',
			'options' => $optsidebar,
			'id' => $prefix.'sidebar',
			'type' => 'select',
			'std' => 'post-sidebar'
		)
	)
);


add_action('admin_menu', 'mytheme_add_box');

// Add meta box
function mytheme_add_box() {
	global $meta_boxes;
	foreach($meta_boxes as $meta_box){
		add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['showbox'], $meta_box['page'], $meta_box['context'], $meta_box['priority']);
	}
}
 
// Callback function to show fields in meta box
function page_sidebar_show_box() {
	global $meta_boxes, $post;
 
	// Use nonce for verification
	echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo mytheme_create_metabox($meta_boxes[0]);
}

// Callback function to show fields in meta box
function post_sidebar_show_box() {
	global $meta_boxes, $post;
 
	// Use nonce for verification
	echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo mytheme_create_metabox($meta_boxes[1]);
}


// Create Metabox Form Table
function mytheme_create_metabox($meta_box){

	global $post;
	
	$returnstring = "";
	
	$returnstring .= '<table class="form-table">';
 
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
 
		$returnstring .= '<tr>'.
				'<th style="width:20%"><label for="'. $field['id']. '">'.$field['name']. '</label></th>'.
				'<td>';
		switch ($field['type']) {
 
//If Text		
			case 'text':
				$textvalue = $meta ? $meta : $field['std'];
				$widthinput = "97%";
				$prefixinput = "";
				$postfixinput = "";
				if(isset($field['class'])){
					if($field['class']=="mini"){
						$widthinput = "20%";
					}
				}
				if(isset($field['prefix'])){
					$prefixinput = stripslashes(trim($field['prefix']));
				}
				if(isset($field['postfix'])){
					$postfixinput = stripslashes(trim($field['postfix']));
				}
				$returnstring .= $prefixinput.'<input type="text" name="'. $field['id']. '" id="'. $field['id']. '" value="'. $textvalue .'" size="30" style="width:'.$widthinput.'" /> '.$postfixinput.
					'<br />'.$field['desc'];
				break;
 
 
//If Text Area			
			case 'textarea':
				$textvalue = $meta ? $meta : $field['std'];
				$returnstring .= '<textarea name="'. $field['id']. '" id="'. $field['id']. '" cols="60" rows="4" style="width:97%">'. $textvalue .'</textarea>'.
					'<br />'.$field['desc'];
				break;
 
//If Select Combobox			
			case 'select':
				$optvalue = $meta ? $meta : $field['std'];
				$returnstring .= '<select name="'. $field['id']. '" id="'. $field['id']. '">';
				foreach ($field['options'] as $option => $val){
					$selectedstr = ($optvalue==$option)? 'selected="selected"' : '';
					$returnstring .= '<option value="'.$option.'" '.$selectedstr.'>'. $val .'</option>';
				}
				$returnstring .= '</select>';
				$returnstring .= '<br />'.$field['desc'];
				break;
				
//If Select Combobox			
			case 'select-slider-category':
				$optvalue = $meta ? $meta : $field['std'];
				$args = array(
				'selected'         => $optvalue,
				'echo'             => 0,
				'taxonomy'           => 'slidercat',
				'name'             =>$field['id'],
				'show_option_all'	=> __('All Categories','dessky')
				);
				$returnstring .= wp_dropdown_categories( $args );
				$returnstring .= '<br />'.$field['desc'];
				break;
				
				
//If Select Combobox			
			case 'select-blog-category':
				$optvalue = $meta ? $meta : $field['std'];
				$args = array(
				'selected'         => $optvalue,
				'echo'             => 0,
				'name'             =>$field['id'],
				'show_option_all'	=> __('All Categories','dessky')
				);
				$returnstring .= wp_dropdown_categories( $args );
				$returnstring .= '<br />'.$field['desc'];
				break;
				

//If Checkbox			
			case 'checkbox':
				$chkvalue = $meta ? true : $field['std'];
				$checkedstr = ($chkvalue)? 'checked="checked"' : '';
				$returnstring .= '<input type="checkbox" name="'. $field['id']. '" id="'. $field['id']. '" '.$checkedstr.' />';
				$returnstring .= '<br />'.$field['desc'];
				break;			
				 
//If Button	
			case 'button':
				$buttonvalue = $meta ? $meta : $field['std'] ;
				$returnstring .= '<input type="button" name="'. $field['id']. '" id="'. $field['id']. '"value="'. $buttonvalue. '" />';
				$returnstring .= '<br />'.$field['desc'];
				break;

 
				
		}
		$returnstring .= 	'<td>'.
						'</tr>';
	}
 
	$returnstring .= '</table>';
	
	return $returnstring;

}//END : mytheme_create_metabox
 
 
add_action('save_post', 'mytheme_save_data');
 
 
// Save data from meta box
function mytheme_save_data($post_id) {
	global $meta_boxes;
 
	// verify nonce
	if(isset($_POST['mytheme_meta_box_nonce'])){
		if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
			return $post_id;
		}
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == isset($_POST['post_type'])) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 	
	foreach($meta_boxes as $meta_box){
		foreach ($meta_box['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = (isset($_POST[$field['id']]))? $_POST[$field['id']] : "";
			
			if($field['type']=='checkbox'){
				if(!isset($_POST[$field['id']])){
					$_POST[$field['id']] = $new = false;
				}
			}
			
			if (isset($_POST[$field['id']]) && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			}
		}
	}
}

?>