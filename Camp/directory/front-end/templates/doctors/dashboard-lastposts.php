<?php
/**
 *
 * The template part for displaying the dashboard menu
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */
global $current_user,$post;
$user_identity 	 = $current_user->ID;
$linked_profile  = doctreat_get_linked_profile_id($user_identity);
$post_id 		 = $linked_profile;
$post_status		= array('publish','pending');

$show_posts 		= 2;
$order 	 			= 'DESC';
$sorting 			= 'ID';

$args = array(
	'posts_per_page' 	=> $show_posts,
    'post_type' 		=> 'post',
    'orderby' 			=> $sorting,
    'order' 			=> $order,
	'post_status' 		=> $post_status,
    'author' 			=> $user_identity,
    'suppress_filters'  => false
);

$query 		= new WP_Query($args);
$width	= 271;
$height	= 194;

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
	<div class="dc-dashboardboxtitle dc-titlewithsearch">
		<h2><?php esc_html_e( 'My last articles', 'doctreat' ); ?></h2>
	</div>
	<div class="dc-dashboardboxcontent">
		<div class="dc-contentdoctab dc-articles-holder  dc-listedarticle">
			<div class="dc-articles">
				<?php if( $query->have_posts() ){ ?>
					<div class="dc-articleslist-content dc-articles-list">
						<?php 
							while ($query->have_posts()) : $query->the_post(); 
								global $post;
								$thumbnail      = doctreat_prepare_thumbnail($post->ID, $width, $height);

								$edit_url		= Doctreat_Profile_Menu::Doctreat_profile_menu_link('manage-article', $user_identity, true,'listings',$post->ID);
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
											<div class="dc-rightarea dc-btnaction">
												<a href="<?php echo esc_url( $edit_url );?>" class="dc-addinfo"><i class="lnr lnr-pencil"></i></a>
												<a href="javascript:;" class="dc-deleteinfo dc-article-delete" data-id="<?php echo intval($post->ID);?>"><i class="lnr lnr-trash"></i></a>
											</div>
											<div class="dc-share-articals dc-display-none">
												<?php doctreat_prepare_social_sharing( false,get_the_title(),true,'',$thumbnail ); ?>
											</div>						
										</div>
									</div>
								</div>
							<?php
							endwhile;
							wp_reset_postdata();
							
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
	<div class="dc-actions">
		<a id="_camp_see_more_articles" class="camp-delete-reference" style="padding-left:10px; padding-right:10px; width:100%;" href="javascript:;">
			<?php esc_html_e( 'Voir plus', 'doctreat' ); ?>
			<span class="lnr lnr-arrow-right-circle"></span>
			<input type="hidden" id="_camp_see_more_articles_link" value="<?php echo get_permalink($linked_profile); ?>">
			<input type="hidden" id="_linked_profile" value="<?php echo $linked_profile; ?>">
		</a>										
	</div>
</div>
