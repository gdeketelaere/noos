<?php
/**
 *
 * The template used for doctors specialiizations
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post;
$post_id = $post->ID;
$video	= get_field('camp_video_youtube_hospitals', $post_id );

$video	= !empty( $video ) ? $video : '';
if( !empty( $video ) ){ ?>
	<div class="dc-specializations dc-aboutinfo">
		<div class="dc-infotitle">
			<h3><?php _e('Vidéo','doctreat');?></h3>
		</div>
		<iframe width="420" height="315"
			src="<?php the_field('camp_video_youtube_hospitals', $post_id); ?>" allow="fullscreen">
		</iframe> 
		
	</div>
<?php } ?>

