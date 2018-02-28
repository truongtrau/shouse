<?php
/**
 * The template for displaying search forms in Think
 *
 * @package WordPress
 * @subpackage WooShop
 * @since WooShop 1.0
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<div class="searcharea">
    <input type="text" name="s" id="s" value="<?php _e('Enter the keyword...','dessky');?>" onfocus="if (this.value == '<?php _e('Enter the keyword...','dessky');?>')this.value = '';" onblur="if (this.value == '')this.value = '<?php _e('Enter the keyword...','dessky');?>';" />
</div>
</form>

