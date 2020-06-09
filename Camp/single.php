<?php
/*
 * Template Name: Post Template Camp
 * Template Post Type: post
 */

global $post;
do_action('doctreat_post_views', $post->ID,'set_blog_view');
get_header();
$doctreat_sidebar 	= 'full';
$section_width    	= 'col-12 col-sm-12 col-md-12 col-lg-12';
$post_meta			= doctreat_get_post_meta( $post->ID );
$am_layout			= !empty( $post_meta['am_layout'] ) ? $post_meta['am_layout'] : '';
$am_sidebar			= !empty( $post_meta['am_sidebar'] ) ? $post_meta['am_sidebar'] : '';

$current_position	= 'full';
if (!empty($am_layout) && $am_layout === 'right_sidebar') {
    $aside_class   		= 'order-last';
    $content_class 		= 'order-first';
	$section_width     	= 'col-12 col-md-12 col-lg-8 col-xl-9';
	$current_position	= 'dc-siderbar';
} elseif (!empty($am_layout) && $am_layout === 'left_sidebar') {
    $aside_class   		= 'order-first';
    $content_class 		= 'order-last';
	$section_width     	= 'col-12 col-md-12 col-lg-8 col-xl-9';
	$current_position	= 'dc-siderbar';
} else {
    $aside_class   = '';
    $content_class = '';
}

//$specialities_tags=camp_get_terms_slug($post->ID,'category');
//$symtomes_tags=camp_get_terms_slug($post->ID,'symtomes');

?>
<div class="dc-haslayout dc-parent-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-8 col-xl-9 order-first ">
				<?php
					while (have_posts()) : the_post();
						global $post, $thumbnail, $post_video, $blog_post_gallery;
				
						if ($current_position !== 'full' && ( !empty( $am_sidebar ) && is_active_sidebar( $am_sidebar ) ) ) {
							$height    = intval(360);
							$width     = intval(825);	
						} else {
							$height    = intval(400);
							$width     = intval(1140);	
						}

						$user_ID   = get_the_author_meta('ID');
						$user_url  = get_author_posts_url($user_ID);
						$thumbnail = doctreat_prepare_thumbnail($post->ID, $width, $height);

						$blog_post_gallery = array();
						$post_video        = '';

						$post_views			= get_post_meta($post->ID,'set_blog_view',true);
						$post_views			= !empty( $post_views ) ? $post_views : 0;
						$post_likes			= get_post_meta($post->ID,'post_likes',true);
						$post_likes			= !empty( $post_likes ) ? $post_likes : 0;

						$post_comments		= get_comments_number($post->ID);
						$post_comments		= !empty( $post_comments ) ? $post_comments : 0 ;

						if (!empty($post_settings['gallery']['blog_post_gallery'])) {
							$blog_post_gallery = $post_settings['gallery']['blog_post_gallery'];
						}

						if (!empty($post_settings['video']['blog_video_link'])) {
							$post_video = $post_settings['video']['blog_video_link'];
						}
						?>
						<div class="dc-runner">
							<?php

								if (get_field('camp_video_content_post', $post->ID )==1) {
									echo get_field('camp_video_youtube_post', $post->ID);
								}
								else
								{
									if (!empty( $thumbnail )	) {
										get_template_part('/template-parts/single-templates/image-single');
									} 
								}
								
							?>
							<div class="dc-runner-content">								
								<div class="dc-runner-heading">
									<h3><?php echo get_the_title($post->ID); ?></h3>
								</div>
								<div class="custom-articlesdocinfo">									
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
										<?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
										<span><?php echo get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) );?></span>
									</a>													
								</div>								
								<div class="dc-my-20 dc-card1" style="float: none;">
									<?php do_action('camp_terms_post_list',$post->ID);?>
									<?php do_action('camp_terms_post_list',$post->ID,'symtomes');?>										
								</div>								
								<ul class="d-flex flex-wrap">
									<li><?php doctreat_get_post_date($post->ID); ?></li>
									<li class="dcget-likes" data-key="<?php echo esc_attr($post->ID);?>"><a href="javascript:;"><i class="ti-heart"></i><?php echo sprintf( _n( '%s Like', '%s Likes', $post_likes, 'doctreat' ), $post_likes );?></a></li>
									<?php if( class_exists( 'DoctreatGlobalSettings' ) ) {?>
										<li><i class="ti-eye"></i><?php echo sprintf( _n( '%s View', '%s Views', $post_views, 'doctreat' ), $post_views );?></li>
									<?php }?>
									<li><i class="ti-comment"></i><?php echo sprintf( _n( '%s Comment', '%s Comments', get_comments_number($post->ID), 'doctreat' ), get_comments_number($post->ID) );?></li>
								</ul>
							</div>
						</div>
						<div class="dc-description">
							<?php
								the_content();
								wp_link_pages(array(
									'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'doctreat') . '</span>',
									'after' => '</div>',
									'link_before' => '<span>',
									'link_after' => '</span>',
								));
							?>
						</div>
						<?php if( function_exists('doctreat_prepare_social_sharing') ){?>
						<div class="dc-my-20 dc-card1">								
							<div class="card-body d-flex dc-card-tags flex-column flex-xl-row">
								<?php //the_tags( '<ul class="d-flex dc-tags1 flex-wrap"><li>'.esc_html__('Tags','doctreat').'</li><li>', '</li><li>', '</li></ul>' ); ?> 
								
								<?php 
									if( function_exists('doctreat_prepare_social_sharing') ){
										doctreat_prepare_social_sharing(false, esc_html__('Share','doctreat'), 'true', '', $thumbnail);
										camp_share_linkedin();
									}
								?>
							</div>
						</div>
						<?php }?> 
						<?php 
							if (comments_open() || get_comments_number()) :
								comments_template();
							endif;
						?>
						</div>
				<?php endwhile; ?>
			<?php
				if ( is_active_sidebar( 'camp-post-side-bar' ) )  {?>
					<div class="col-12 col-md-8 col-lg-4 col-xl-3  order-last">
						<aside id="dc-sidebar" class="dc-sidebar dc-sidebar-grid mt-lg-0">
							<?php dynamic_sidebar( 'camp-post-side-bar' );?>
						</aside>
					</div>
					<?php
				}
			?>
		</div>
	</div>
</div>
<?php
get_footer();