<?php 
/**
 *
 * The template part for displaying the Articles listings
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */

$post_status		= array('publish');
$show_posts 		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$pg_page 			= get_query_var('page') ? get_query_var('page') : 1; 
$pg_paged 			= get_query_var('paged') ? get_query_var('paged') : 1;
$paged 				= max($pg_page, $pg_paged);
$order 	 			= 'DESC';
$sorting 			= 'ID';
$args = array(
	'posts_per_page' 	=> $show_posts,
    'post_type' 		=> 'post',
    'orderby' 			=> $sorting,
    'order' 			=> $order,
	'post_status' 		=> $post_status,
    'paged' 			=> $paged,
    'suppress_filters'  => false
);

$query 		= new WP_Query($args);
$count_post = $query->found_posts;
$width	= 271;
$height	= 194;
?>
<div class="dc-dashboardboxcontent">
	<div class="dc-contentdoctab dc-articles-holder  dc-listedarticle">
		<div class="dc-articles">
			<?php if( $query->have_posts() ){ ?>
				<div class="dc-articleslist-content dc-articles-list">
					<?php 
						while ($query->have_posts()) : $query->the_post(); 
							global $post;
							$thumbnail      = doctreat_prepare_thumbnail($post->ID, $width, $height);

							//$edit_url		= Doctreat_Profile_Menu::Doctreat_profile_menu_link('manage-article', $user_identity, true,'listings',$post->ID);
							$categries		=  get_the_term_list( $post->ID, 'category', '', ',', '' );
							?>
							<div class="dc-article">
								<figure class="dc-articleimg">
									<?php if( !empty( $thumbnail ) ){?>
										<img src="<?php echo esc_url( $thumbnail );?>" alt="<?php echo esc_attr( get_the_title());?>" />
									<?php } ?>
									<?php do_action('doctreat_get_article_author',$post_id);?>
								</figure>
								<div class="dc-articlecontent">
									<div class="dc-title">
										<?php if( !empty( $categries ) ) { ?><div class="dc-tag-v2"><?php echo do_shortcode( $categries );?></div><?php }?>
										<h3><a href="<?php echo esc_url( get_the_permalink() );?>"><?php the_title();?></a></h3>
										<?php do_action('doctreat_post_date',$post->ID);?>
									</div>
									<div class="dc-optionarea">
										<?php do_action('doctreat_get_article_sharing',$post->ID);?>										
										<div class="dc-share-articals dc-display-none">
											<?php doctreat_prepare_social_sharing( false,get_the_title(),true,'',$thumbnail ); ?>
										</div>						
									</div>
								</div>
							</div>
						<?php
						endwhile;
						wp_reset_postdata();			 

						if (!empty($count_post) && $count_post > $show_posts) {
							doctreat_prepare_pagination($count_post, $show_posts);
						}
					?>
				</div>
				<?php 
				} else{ 
					do_action('doctreat_empty_records_html','dc-empty-articls dc-emptyholder-sm',esc_html__( 'No Articl posted yet.', 'doctreat' ));
				} 
			?>
		</div>
	</div>
</div>