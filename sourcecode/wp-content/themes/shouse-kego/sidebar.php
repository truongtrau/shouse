

<?php

global $post;

$custom = get_post_custom($post->ID);
$prefix = "dessky_";
$defaultsidebar = "post-sidebar";
$postsidebar = (isset($custom[$prefix."sidebar"][0]) && !is_search())? $custom[$prefix."sidebar"][0] : $defaultsidebar;
?>
<div class="widget-area">
	<?php if ( ! dynamic_sidebar( $postsidebar ) ) : ?><?php endif; // end general widget area ?>
</div>