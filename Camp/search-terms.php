<?php
/**
 *
 * Theme Search Page
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
get_header();
global $paged,$wp_query;
$search_show_posts    = get_option('posts_per_page');
$aside_class 	= 'pull-right';
$content_class 	= 'pull-left';
if ( is_active_sidebar( 'sidebar-1' ) ) {
	$section_width  = 'col-xs-12 col-sm-12 col-md-12 col-lg-8';
} else{
	$section_width  = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
}
$type = get_query_var( 'c_see_more_type' );
$key = get_query_var( 'c_see_more_filter_key' );
$value = get_query_var( 'c_see_more_filter_value' );
?>
<div class="container">
    <div class="row">
        <div class="<?php echo esc_attr( $section_width );?> page-section <?php echo sanitize_html_class($content_class); ?>">
			<div class="dc-haslayout search-page-header">
				<div class="border-left dc-haslayout">
					<h3><?php printf(esc_html__('Search Results for : %s' , 'doctreat') , get_search_query() ); ?></h3>
				</div>
				<div class="need-help dc-haslayout">
					<h4><?php  esc_html_e('Need a new search?','doctreat');?> </h4>
					<p><?php  esc_html_e('If you didn\'t find what you were looking for, try a new search!','doctreat');?></p>
				</div>
				<div class="dc-blog-search dc-haslayout">
					<?php get_search_form();?>
				</div>
			</div>
			<?php 
				if ( have_posts() && $type ==='post') {
					while(have_posts()) :the_post();
						global $post;
						$width 		= 1140;
						$height 	= 400;
						$thumbnail  = doctreat_prepare_thumbnail($post->ID , $width , $height);
						
						$stickyClass = '';
						if (is_sticky()) {
							$stickyClass = 'sticky';
						}
					
						$categries		=  get_the_term_list( $post->ID, 'category', '', '', '' );
					?>
						<article class="dc-article <?php echo esc_attr($stickyClass);?>">
							<div class="dc-articlecontent">
								<?php if( !empty( $thumbnail ) ){?>
									<figure class="dc-classimg">
										<?php doctreat_get_post_thumbnail($thumbnail,$post->ID,'linked');?>
									</figure>
								<?php }?>
								
								<div class="dc-title">
									<h3><?php doctreat_get_post_title($post->ID); ?></h3>
								</div>
								<div class="dc-description">
									<p><?php echo doctreat_prepare_excerpt(350); ?></p>
									<?php if(!empty( $categries )){?>
										<div class="dc-tagslist tagcloud d-flex dc-tags1 flex-wrap"><span><?php esc_html_e('Categories','doctreat');?>:&nbsp;</span><?php echo do_shortcode($categries);?></div>
									<?php }?>
									<?php
										if( function_exists('doctreat_get_article_meta') ){
											do_action('doctreat_get_article_meta',$post->ID);
										}
									?>
								</div>
								<?php if ( is_sticky() ) {?>
									<span class="sticky-wrap dc-themetag dc-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Featured','doctreat');?></span>
								<?php }?>
							</div>
						</article>						
					<?php endwhile; 
					wp_reset_postdata();
					$qrystr = '';
					if ($wp_query->found_posts > $search_show_posts) {?>
						<div class="theme-nav">
							<?php 
								if (function_exists('doctreat_prepare_pagination')) {
									echo doctreat_prepare_pagination($wp_query->found_posts , $search_show_posts);
								}
							?>
						</div>
				<?php }
				}?>
				<?php 
				if ( have_posts() && $type ==='doctors') {?>
					<div class="dc-docpostholder dc-search-doctors">
						<?php while(have_posts()) :the_post(); global $post; ?>
							<div class="dc-docpostcontent">
								<div class="dc-searchvtwo">
									<?php do_action('doctreat_get_doctor_thumnail',$post->ID);?>
									<?php do_action('doctreat_get_doctor_details',$post->ID);?>
									<?php do_action('doctreat_get_doctor_services',$post->ID,'services');?>
								</div>
								<?php do_action('doctreat_get_doctor_booking_information',$post->ID);?>
							</div>					
						<?php endwhile; 
						wp_reset_postdata();
						$qrystr = '';
						if ($wp_query->found_posts > $search_show_posts) {?>
							<div class="theme-nav">
								<?php 
									if (function_exists('doctreat_prepare_pagination')) {
										echo doctreat_prepare_pagination($wp_query->found_posts , $search_show_posts);
									}
								?>
							</div>
					<?php }?>
					</div><?php
				}?>
				<?php
				if ( $type ==='symtomes' || $type ==='specialities') {
					$args = array(
						'taxonomy'               => $type,
						'orderby'                => 'name',
						'order'                  => 'ASC',
						'hide_empty'             => false,
						'meta_query' => array(
							array(
								'key'     => $key,
								'value'   => $value
							),
						),
					);					
					$the_query = new WP_Term_Query($args);
					foreach($the_query->get_terms() as $term) :
					?>
						<article class="dc-article <?php echo esc_attr($stickyClass);?>">
							<div class="dc-articlecontent">
								<?php if( get_field('camp_photo_'.$type,'term_'.$term->term_id) ){?>
									<figure class="dc-classimg">
										<img style="width:1140px; height:400px;" alt="<?php echo $term->name; ?>" src="<?php the_field('camp_photo_'.$type,'term_'.$term->term_id); ?>">																				
									</figure>
								<?php }?>
								
								<div class="dc-title">
									<h3><?php echo $term->name; ?></h3>
								</div>
								<div class="dc-description">
									<p><?php echo $term->description; ?></p>									
								</div>
								<a href="<?php echo get_term_link($term, $type); ?>" class="dc-btn" data-no-translation=""><?php _e( 'Lire la suite','camp' );?></a>
							</div>
						</article>						
					<?php endforeach; 
					wp_reset_postdata();
					$qrystr = '';
					if ($the_query->found_posts > $search_show_posts) {?>
						<div class="theme-nav">
							<?php 
								if (function_exists('doctreat_prepare_pagination')) {
									echo doctreat_prepare_pagination($the_query->found_posts , $search_show_posts);
								}
							?>
						</div>
				<?php }
				}?>
			
					
		</div>
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) {?>
			<aside id="dc-sidebar" class="col-xs-12 col-sm-12 col-md-12 col-lg-4 dc-sidebar-grid mt-lg-0 <?php echo sanitize_html_class($aside_class); ?>">
				<div class="dc-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</aside>
		<?php } ?>
    </div>
</div>
<?php get_footer(); ?>