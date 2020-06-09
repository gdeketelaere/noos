<?php
/**
 *
 * The template used for displaying Gallery
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post;
$post_id = $post->ID;
$images  	= doctreat_get_post_meta( $post_id,'am_gallery');
$title		= get_the_title($post_id);

if( !empty( $images ) && is_array( $images ) ){?>
	<div class="dc-gallery-holder dc-aboutinfo">
		<div class="dc-infotitle">
			<h3><?php esc_html_e('Gallery','doctreat');?></h3>
		</div>
		<div class="gallery-img">
			<div class="dc-projects">
				<?php 
					foreach( $images as $key => $gallery_image ){ 
						$gallery_thumnail_image_url 	= !empty( $gallery_image['attachment_id'] ) ? wp_get_attachment_image_src( $gallery_image['attachment_id'], array(255,200), true ) : '';
						$gallery_image_url 				= !empty( $gallery_image['url'] ) ? $gallery_image['url'] : '';
						
				?>
				<div class="dc-project dc-crprojects">
					<?php if( !empty($gallery_thumnail_image_url[0]) ){?>
						<a  data-rel="prettyPhoto[gallery]" href="<?php echo esc_url($gallery_image_url);?>"  rel="prettyPhoto[gallery]">
							<figure><img src="<?php echo esc_url( $gallery_thumnail_image_url[0] );?>" alt="<?php echo esc_attr($title);?>"></figure>
						</a>
					<?php }?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<script type="application/javascript">
		jQuery(document).ready(function () {
			jQuery("a[data-rel]").each(function () {
				jQuery(this).attr("rel", jQuery(this).data("rel"));
			});
			jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
				animation_speed: 'normal',
				theme: 'dark_square',
				slideshow: 3000,
				default_width: 800,
				default_height: 500,
				allowfullscreen: true,
				autoplay_slideshow: false,	
				social_tools: false,
				iframe_markup: "<iframe src='{path}' width='{width}' height='{height}' frameborder='no' allowfullscreen='true'></iframe>", 
				deeplinking: false
			});
		});
	</script>
<?php }?>

