<?php 
/**
 *
 * The template part for displaying doctors in listing like team
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */
global $post,$current_user;
$user_identity  = $current_user->ID;
$link_id		= doctreat_get_linked_profile_id( $user_identity );
$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
$paged 			= max($pg_page, $pg_paged);

$order 			= 'DESC';
$sorting 		= 'ID';
$meta_query_args = array();

$args 			= array(
					'posts_per_page' 	=> $show_posts,
					'post_type' 		=> 'hospitals_team',
					'orderby' 			=> $sorting,
					'order' 			=> $order,
					'post_status' 		=> array('publish','pending','draft'),
					'paged' 			=> $paged,
					'suppress_filters' 	=> false
				);



$meta_query_args[] = array(
						'key' 		=> 'hospital_id',
						'value' 	=> $link_id,
						'compare' 	=> '='
					);
$query_relation 	= array('relation' => 'AND',);
$args['meta_query'] = array_merge($query_relation, $meta_query_args);

$query 				= new WP_Query($args);

$count_post 		= $query->found_posts;

//
$args_doctors_search = array(
					'posts_per_page' 	=> $show_posts,
					'post_type' 		=> 'doctors',
					'orderby' 			=> $sorting,
					'order' 			=> $order,
					'post_status' 		=> array('publish'),
					'paged' 			=> $paged,
					'suppress_filters' 	=> false
				);
$query_2 				= new WP_Query($args_doctors_search);

$count_post_2 		= $query_2->found_posts;



?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
	<div class="dc-dbsectionspacetest">
		<div class="dc-dashboardbox dc-manageteam-wrap"><?php
			if (isset($_SESSION['camp_send_invit']) && $_SESSION['camp_send_invit']=="yes" ) {
				echo '<div id="message" class="alert-success">
					<p>Votre invitation a été envoyée avec succes</p></div>';
				$_SESSION['camp_send_invit']="";
			}
			if (isset($_SESSION['camp_send_invit']) && $_SESSION['camp_send_invit']=="no" ){
				echo '<div id="message">
					<p style="color:red;">Une erreur est survenue lors de l\'envoi. veuillez ressayer...</p></div>';
			}?>	
			<div class="dc-searchresult-head">
				<div class="dc-title"><h3><?php esc_html_e('Manage Team','doctreat');?></h3></div>
				<div class="dc-rightarea">
					<a href="javascript:;"  class="dc-btn dc-invitation-users dc-btn-tab"><?php esc_html_e('Invite doctors','doctreat');?></a>
					<a style="margin-left: 5px;" data-toggle="collapse" href="#collapse_add_invitation_doctors" aria-expanded="false" aria-controls="#collapse_add_invitation_doctors"  class="dc-btn dc-btn-tab"><?php esc_html_e('Avanced Invite doctors ','doctreat');?></a>
				</div>				
			</div>
			<!-- Open The Modal -->
			<div class="collapse" id="collapse_add_invitation_doctors">
				<div class="container"> 
				    <div class="row">
				        <div class="col-xs-12 col-sm-offset-12 col-sm-12">
				            <div class="panel panel-default">
				                <div class="panel-heading c-list" style="color:#333;background-color:#f5f5f5;border-color: #ddd; display: flex;">
				                    <span class="title"><?php esc_html_e('Doctors List ','doctreat');?></span>
				                    <ul class="pull-right c-controls">		                        
				                        <li><input type="text" name="contact-list-search" id="contact-list-search" placeholder="search here..." onkeyup="camp_ajax_fetch()"></input></li>
				                    </ul>
				                </div>			          
				                
				                <ul class="list-group" id="contact-list">
				                	<?php if( $query_2->have_posts() ){ 								 
										$user_detail= get_userdata($current_user->ID);
										$current_profile=doctreat_get_linked_profile_id( $user_identity);
										while ($query_2->have_posts()) : $query_2->the_post();
											
											global $post;
											
											if ($post->ID !== $current_profile) :
												$doctor_id	= doctreat_get_linked_profile_id( $post->ID,'post' );
												$doctor_info = get_userdata($doctor_id);
												$doctor_email = $doctor_info->user_email;				
												
												$address		= get_post_meta( $post->ID , '_address',true );
												$address		= !empty( $address ) ? $address : 'No adress found!';
												?>
							                    <li class="list-group-item" style="display: flex;">
							                        <div class="col-xs-12 col-sm-3">
							                            <img src="<?php the_post_thumbnail_url();?>" alt="<?php the_title();?>" style="border-radius: 50%;" class="img-responsive img-circle" />
							                        </div>
							                        <div class="col-xs-12 col-sm-9">
							                        	<span class="name"><?php the_title();?></span><br/>

							                            <span class="lnr lnr-map-marker text-muted c-info" data-toggle="tooltip" title="<?php echo $address;?>"></span>	                            
							                            
							                            <span class="lnr lnr-bubble text-muted c-info" data-toggle="tooltip" title="<?php echo $doctor_email;?>"></span>
							                            
														                                                 
							                             	

							                            <a data-toggle="collapse" href="<?php echo '#collapse'.$post->ID;?>" aria-expanded="false" aria-controls="<?php echo '#collapse'.$post->ID;?>" ><span class="lnr lnr-select"></span></a>

							                            <div class="collapse" id="<?php echo 'collapse'.$post->ID; ?>">	                            	
														    <div class="container">						
																<div class="dc-collapseexp" style="background-color: transparent;">
																	<div class="dc-formtheme dc-userform">
																		<fieldset>
																			<form action="" method="post">		
																				<div class="form-group">
																					<textarea class="form-control" name="_desc_invit" placeholder="<?php esc_html_e('Laissez un message','doctreat');?>"></textarea>
																				</div>
																				<div class="form-group">				
																				<input type= "hidden" name="doctor_email_invit" value="<?php echo $doctor_info->user_email ;?>">		
																					
																				<input type= "hidden" name="camp_action_" value="add_invit">			
																				<input type= "submit" class="add-repeater-services dc-btn" value="<?php esc_attr_e('Send invit','doctreat');?>">
																				</div>
																			</form>								
																		</fieldset>
																	</div> 						  
																</div>
															</div>										
														 </div>	
														<!-- The Modal -->		

							                        </div>

							                        
							                        <div class="clearfix"></div>
							                    </li><?php 
											endif;								
						                
										endwhile;
										wp_reset_postdata();
					
										if (!empty( $count_post_2 ) && $count_post_2 > $show_posts) {
											doctreat_prepare_pagination( $count_post_2, $show_posts );
										}
									?>
								<?php } else { 
									do_action('doctreat_empty_records_html','dc-empty-saved-doctors dc-emptyholder-sm',esc_html__( 'Empty Doctor list.', 'doctreat' ));
								} ?>			                    				                    
				                </ul>
				            </div>
				        </div>
					</div>
				</div>				     
			</div>	
			<!-- The Modal -->
			<div class="dc-recentapoint-holder">
				<?php if( $query->have_posts() ){ ?>
				<?php 
					while ($query->have_posts()) : $query->the_post();
						global $post;
						$doctors_id 			= get_post_field ('post_author', $post->ID);
						$doctor_profile_id		= doctreat_get_linked_profile_id( $doctors_id );
	
						$name		= doctreat_full_name( $doctor_profile_id );
						$name		= !empty( $name ) ? $name : ''; 
						
						$link		= get_the_permalink( $doctor_profile_id );
						$status		= get_post_status( $post->ID );
	
						$width		= 30;
						$height		= 30;
	
						$avatar_url = apply_filters(
										'doctreat_doctor_avatar_fallback', 
										doctreat_get_doctor_avatar( array('width' => $width, 'height' => $height ), $doctor_profile_id ), 
										array( 'width' => $width, 'height' => $height )
									);
						?>
						<div class="dc-recentapoint">
							<div class="dc-recentapoint-content dc-apoint-noti dc-noti-colorone">
								<?php if( !empty( $avatar_url ) ){?>
									<div class="dc-recentapoint-figure">
										<figure><img src="<?php echo esc_url( $avatar_url );?>" alt="<?php echo esc_attr( $name );?>"></figure>
									</div>
								<?php } ?>
								<div class="dc-recent-content">
									<?php if( !empty( $name ) || !empty( $status ) ){?>
										<span>
											<a href="<?php echo esc_url( $link );?>"><?php echo esc_html( $name );?></a>
											<em><?php esc_html_e('Status','doctreat');?>: <?php echo esc_html( ucfirst($status) );?></em>
										</span>
									<?php } ?>
									<div class="dc-recent-contenttest">
										<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('location', $user_identity, false, 'details', $post->ID); ?>" class="dc-btn dc-btn-sm"><?php esc_html_e('View Details','doctreat');?></a>    
										<?php if( $status === 'pending' || $status === 'draft' ){?>
											<a href="javascript:;" data-id="<?php echo intval($post->ID);?>" data-status="publish" class="dc-btn dc-btn-sm dc-chage-status"><?php esc_html_e('Approve User','doctreat');?></a>
										<?php } ?>    
										<?php if( $status === 'pending' || $status === 'draft' || $status === 'publish'){?>
											<a href="javascript:;" data-id="<?php echo intval($post->ID);?>" data-status="trash" class="dc-userbtn dc-chage-status"><?php esc_html_e('Reject User','doctreat');?></a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php 
						endwhile;
						wp_reset_postdata();
	
						if (!empty( $count_post ) && $count_post > $show_posts) {
							doctreat_prepare_pagination( $count_post, $show_posts );
						}
					?>
				<?php } else { 
					do_action('doctreat_empty_records_html','dc-empty-saved-doctors dc-emptyholder-sm',esc_html__( 'Empty team members.', 'doctreat' ));
				} ?>
			</div>
		</div>
	</div>
</div>
<?php
	get_template_part('directory/front-end/templates/dashboard', 'add-invitation');?>