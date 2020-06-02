<?php
/**
 *
 * The template used for hospital details
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post,$theme_settings;
$post_id 	= $post->ID;
$name		= doctreat_full_name( $post_id );
$name		= !empty( $name ) ? $name : ''; 
$gallery_option		= !empty($theme_settings['enable_gallery']) ? $theme_settings['enable_gallery'] : '';
$am_phone_numbers	= doctreat_get_post_meta( $post_id,'am_phone_numbers');
$am_web_url			= doctreat_get_post_meta( $post_id,'am_web_url');

$latitude		= get_post_meta( $post_id , '_latitude',true );
$latitude		= !empty( $latitude ) ? $latitude : '';
$longitude		= get_post_meta( $post_id , '_longitude',true );
$longitude		= !empty( $longitude ) ? $longitude : '';
?>
<div class="dc-contentdoctab dc-userdetails-holder active tab-pane" id="userdetails">
	<div class="dc-aboutdoc dc-aboutinfo">
		<div class="dc-infotitle">
			<h3><?php esc_html_e( 'About','doctreat');?> “<?php echo esc_html( $name );?>”</h3>
		</div>
		<div class="dc-description"><?php the_content();?></div>
	</div>
	<?php get_template_part('directory/front-end/templates/hospitals/single/languages'); ?>
	<?php get_template_part('directory/front-end/templates/hospitals/single/kidsfriendly'); ?>
	<?php
		if(!empty($gallery_option)){
			get_template_part('directory/front-end/templates/gallery');
		}
	?>
	<?php get_template_part('directory/front-end/templates/hospitals/single/video'); ?>
</div>
<?php
	$script = "jQuery(document).ready(function (e) {
				jQuery.doctreat_init_profile_map(0,'location-pickr-map', ". esc_js($latitude) . "," . esc_js($longitude) . ");
			});";
	wp_add_inline_script('doctreat-maps', $script, 'after');