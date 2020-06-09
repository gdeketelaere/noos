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


global $current_user;
$user_identity 	 = $current_user->ID;

$linked_profile  = doctreat_get_linked_profile_id($user_identity);
$post_id 		 = $linked_profile;



$user_info = get_userdata($user_identity);
//$user_roles= implode(',', $user_info->roles);
$user_roles= $user_info->roles;
$user_type=(string)$user_roles[0];

if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
$paged 			= max($pg_page, $pg_paged);
$order 			= 'DESC';
$sorting 		= 'ID';

$notice="";
if (isset($_SESSION['camp_reference_delete']) && !empty($_SESSION['camp_reference_delete']) && isset($_SESSION['camp_reference_delete_notice']) && $_SESSION['camp_reference_delete_notice']=="yes"){
		$ref=$_SESSION['camp_reference_delete'];
		$save_ref_ids= get_post_meta( $post_id, '_saved_references', true);
		unset($save_ref_ids[$ref]);
		update_post_meta($post_id, '_saved_references', $save_ref_ids);
		$notice='<div id="message" class="alert-success">
			<p>La référence a été supprimée avec succes</p></div>';
		$_SESSION['camp_reference_delete_notice']="";
		$_SESSION['camp_reference_delete']="";
}

if (isset($_SESSION['camp_reference_modified']) && !empty($_SESSION['camp_reference_modified']) && isset($_SESSION['camp_reference_modified_notice']) && $_SESSION['camp_reference_modified_notice']=="yes"){
		
		$save_ref_ids= get_post_meta( $post_id, '_saved_references', true);

		$ref=$_SESSION['camp_reference_modified']['id'];
		$save_ref_ids[$ref]['comment']=$_SESSION['camp_reference_modified']['comment'];

		update_post_meta($post_id, '_saved_references', $save_ref_ids);
		$notice='<div id="message" class="alert-success">
			<p>La référence a été mise à jour avec succes</p></div>';
		$_SESSION['camp_reference_delete_notice']="";
		$_SESSION['camp_reference_modified']=array();
}

$save_references_ids	= get_post_meta( $post_id, '_saved_references', true);

$empty_array[] = array('id'=>0, 'comment'=>'');
$array_ids=!empty($save_references_ids) ? $save_references_ids : $empty_array;



$post_array_ids=array();

foreach ($array_ids as $key => $value) {

	$post_array_ids[]=$value['id'];

}

$args = array(
	'posts_per_page' 	=> $show_posts,
    'post_type' 		=> $user_type,
    'orderby' 			=> $sorting,
    'order' 			=> $order,
    'paged' 			=> $paged,
	'post__in' 		    => $post_array_ids,
    'suppress_filters' 	=> false
);

$loop = new WP_Query($args);
$count_post = $loop->found_posts;

echo $notice;
//print_r($post_array_ids); print_r($array_ids);

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right">
	<div class="dc-dashboardbox dc-dashboardinvocies">
		<div class="dc-dashboardboxtitle dc-titlewithsearch">
			<h2><?php esc_html_e( 'References Saved', 'doctreat' ); ?></h2>
		</div>
		<div><input type="text" name="ref-saved-list-search" id="ref-saved-list-search" placeholder="search here..." onkeyup="camp_ajax_fetch_ref_saved()"></input></div>

		<div class="dc-dashboardboxcontent dc-categoriescontentholder dc-categoriesholder">		
			<div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo" id="references-saved-list">
				<?php

					if($loop->have_posts()) :

					    while($loop->have_posts()) : $loop->the_post();

					    	global $post;
					    	$post_ref_id=$post->ID;
					    	$featured	= get_post_meta(get_the_ID(),'is_featured',true);
					    	$verified	= get_post_meta($post_ref_id, '_is_verified', true);
							$verified	= !empty( $verified ) ? $verified	: '';

							$comment = camp_get_comment_reference ($post_id, get_the_ID());
							$comment = !empty($comment) ? $comment : '' ;
							$comment_resume = substr($comment, 0,50);
			    	
				?>
							<div class="dc-docpostholder">
								<div class="dc-docpostcontent" style="display: flex; flex-wrap: wrap; justify-content: space-around;">	
									<div class="dc-searchvtwo" style="width: 80%; padding: 10px;">								
										<figure class="dc-docpostimg" style="width: 100px;">
											<img class="dc-image-res" src="<?php the_post_thumbnail_url(); ?>" alt="Summer spring Hospital">
											<img class="dc-image-res-2x" src="<?php the_post_thumbnail_url(); ?>" alt="Summer spring Hospital">
										</figure>
										<div class="dc-title">
											<div class="dc-doc-specilities-tag">
												<?php do_action('camp_specilities_list',$post_ref_id);?>
												<?php do_action('camp_specilities_list',$post_ref_id,'symtomes');?>
											</div>
											<h3 style="width: 100%;">
												<a href="<?php the_permalink();?>"><?php the_title();?></a>
												<?php if (!empty($_is_verified)) {?>
													<i class="far fa-check-circle dc-awardtooltip dc-tipso tipso_style" style="color:#1abc9c;" data-tipso="Verified user"></i><?php
												}
												?>												
											</h3>
											<ul class="dc-docinfo">
												<li><em><?php echo $comment_resume.'...'; ?></em></li>
											</ul>							
										</div>
									</div>
									<div class="dc-actions" style="width: 20%;">
										<a data-toggle="collapse" class="camp-edit-reference" href="<?php echo '#collapse_modified'.$post_ref_id;?>" aria-expanded="false" aria-controls="<?php echo '#collapse_modified'.$post_ref_id;?>">
											<span class="lnr lnr-pencil"></span>
										</a>
										<a data-toggle="collapse" class="camp-delete-reference" href="<?php echo '#collapse'.$post_ref_id;?>" aria-expanded="false" aria-controls="<?php echo '#collapse'.$post_ref_id;?>">
											<span class="lnr lnr-trash"></span>
										</a>										
									</div>						
								</div>
							</div>
							<!-- Open The Modal -->
							<div class="collapse" id="<?php echo 'collapse'.$post_ref_id;?>">
							    <div class="container">
									<div class="dc-tabscontenttitle dc-addnew camp-delete-reference-confirm">
										<h3><?php esc_html_e('Voulez-vous supprimer cette recommandation?','doctreat');?></h3>
									</div>					
									<div class="dc-collapseexp" style="background-color: transparent;">
										<div class="dc-formtheme dc-userform">
											<fieldset>
												<form action="" method="post">		
													<div class="form-group">
														<input type= "hidden" name="camp_post_id_ref2" value="<?php echo $post_ref_id ;?>">
														<input type= "hidden" name="camp_post_id_user_ref2" value="<?php echo $post_id ;?>">
														<input type= "hidden" name="camp_action_ref2" value="delete">			
														<input type= "submit" class="camp-delete-reference-confirm-btn dc-btn" value="<?php esc_attr_e('delete recommandation','doctreat');?>">
													</div>
												</form>								
											</fieldset>
										</div> 						  
									</div>
								</div>
							</div>	
							<!-- The Modal -->	
							<div class="collapse" id="<?php echo 'collapse_modified'.$post_ref_id;?>">
							    <div class="container">
									<div class="dc-tabscontenttitle dc-addnew">
										<h3><?php esc_html_e('Modifier le texte de recommandation','doctreat');?></h3>
									</div>					
									<div class="dc-collapseexp" style="background-color: transparent;">
										<div class="dc-formtheme dc-userform">
											<fieldset>
												<form action="" method="post">		
													<div class="form-group">
														<input type= "hidden" name="camp_post_id_ref2" value="<?php echo $post_ref_id ;?>">
														<input type= "hidden" name="camp_post_id_user_ref2" value="<?php echo $post_id ;?>">
														<input type= "hidden" name="camp_action_ref2" value="modified">

														<div class="form-group">
															<textarea class="form-control" name="camp_desc_reference_modified" placeholder="<?php esc_html_e('Laissez un commentaire','doctreat');?>"><?php echo $comment;?></textarea>
														</div>			
														<input type= "submit" class="dc-btn" value="<?php esc_attr_e('Update recommandation','doctreat');?>">
													</div>
												</form>								
											</fieldset>
										</div> 						  
									</div>
								</div>
							</div>	
							<!-- The Modal -->			
													
						<?php endwhile;

						if ( !empty($count_post) && $count_post > $show_posts ) :
							doctreat_prepare_pagination($count_post, $show_posts );
						endif; 

					else: do_action('doctreat_empty_records_html','dc-empty-saved-doctors',esc_html__( 'No item found!', 'doctreat' ));
					endif;
				?>
			</div>			
		</div>
	</div>
</div>
<script type="text/javascript">
	function camp_ajax_fetch_ref_saved(){
	    jQuery.ajax({
	        url: '<?php echo admin_url('admin-ajax.php'); ?>',
	        type: 'post',
	        data: { action: 'camp_data_fetch_ref_saved', keyword_search_ref_saved : jQuery('#ref-saved-list-search').val() },
	        success: function(data) {
	            jQuery('#references-saved-list').html( data );
	        }
	    });

	}
</script>