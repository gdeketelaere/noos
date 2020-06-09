<?php
/**
 *
 * The template used for hospital basics
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post,$current_user;

$post_id 	= $post->ID; 
$user_id	= doctreat_get_linked_profile_id( $post_id,'users' );
$verified	= get_post_meta($post_id, '_is_verified', true);
$verified	= !empty( $verified ) ? $verified	: '';
$shoert_des		= doctreat_get_post_meta( $post_id, 'am_short_description');
$tagline		= doctreat_get_post_meta( $post_id, 'am_sub_heading');
$mrv			= doctreat_get_post_meta( $post_id, 'am_registration_number');

$name			= doctreat_full_name( $post_id );
$name			= !empty( $name ) ? $name : ''; 

$feedback			= get_post_meta($post_id,'review_data',true);
$feedback			= !empty( $feedback ) ? $feedback : array();
$total_rating		= !empty( $feedback['dc_total_rating'] ) ? $feedback['dc_total_rating'] : 0 ;
$total_percentage	= !empty( $feedback['dc_total_percentage'] ) ? $feedback['dc_total_percentage'] : 0 ;

$doctor_avatar = apply_filters(
		'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar( array( 'width' => 255, 'height' => 250 ), $post_id ), array( 'width' => 255, 'height' => 250 )
	);

$doctor_avatar_2x = apply_filters(
		'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar( array( 'width' => 545, 'height' => 428 ), $post_id ), array( 'width' => 545, 'height' => 428 )
	);
//Ajout Cyril K

$system_access	= !empty($theme_settings['system_access']) ? $theme_settings['system_access'] : '';
$featured	= get_post_meta($post_id,'is_featured',true);
$address		= get_post_meta( $post->ID , '_address',true );
$address		= !empty( $address ) ? $address : 'Paris';
$map = do_shortcode( '[camp_map]' );
?>
<div class="dc-docsingle-header">
	<?php if( !empty( $doctor_avatar ) ){?>
		<figure class="dc-docsingleimg">
			<img class="dc-ava-detail" src="<?php echo esc_url( $doctor_avatar );?>" alt="<?php echo esc_attr( get_the_title() );?>">
			<img class="dc-ava-detail-2x" src="<?php echo esc_url( $doctor_avatar_2x );?>" alt="<?php echo esc_attr( get_the_title() );?>">
		</figure>
	<?php } ?>
	<div class="dc-docsingle-content dc-hossingle-content">
		<div class="dc-title">
		<?php// do_action('doctreat_specilities_list',$post_id,1);?>
			<h2>
				<a href="<?php esc_url( the_permalink() );?>"><?php echo esc_html( $name );?></a>
				<?php //do_action('doctreat_get_drverification_check',$post_id,esc_html__('Medical Registration Verified','doctreat'));?>
				<?php do_action('doctreat_get_verification_check',$post_id,'Verified center');?>
			</h2>
			<div class="dc-docinfo">				
				<div><?php echo $map ;?></div>					
				<p>
					<i class="lnr lnr-location"></i><?php echo $address ;?>
				</p>
			</div>
			<?php do_action('camp_specilities_list',$post_id);?>
			<?php do_action('camp_specilities_list',$post_id,'symtomes');?>
		</div>
		<div class="dc-btnarea">
			<a href="#" class="dc-btn" id ="myBtn"><?php _e('Contact','doctreat');?></a>
				<?php if(empty($booking_option)){?>
					<a href="javascript:;" class="dc-btn dc-booking-model" data-access="<?php echo esc_attr($system_access);?>"><?php _e('Book Now','doctreat');?></a>
				<?php } else { ?>
					<a href="javascript:;" data-id="<?php echo intval( $post_id );?>" class="dc-btn dc-booking-contacts"><?php _e('Call Now','doctreat');?></a>
				<?php } ?>				
			<?php do_action('camp_get_favorit_check',$post_id,'large');?>
		</div>
		<div class="dc-btnarea">
			<?php doctreat_prepare_social_sharing( false,esc_html__('Share Profile','doctreat'),true,'dc-simplesocialicons dc-socialiconsborder',$thumbnail ); ?>
		</div>
	</div>
</div>
<div id="myModal" class="modal">
    <!-- Modal content -->
	<div class="modal-content">
	    <div class="modal-header">
	        <span class="close">×</span>
	      
			<div class="container">
				<div class="dc-tabscontenttitle dc-addnew">
					<h3><?php esc_html_e('Contact ','doctreat'); echo $name; ?></h3>
				</div>					
				<div class="dc-collapseexp" style="background-color: transparent;">
					<div class="dc-formtheme dc-userform">
						<fieldset>
							<form action="" method="post"">
		    					<?php wp_nonce_field( "action_camp_contact_hospitals", "camp_contact_hospitals", true, true );?>		    						
								<div class="form-group form-group-half">
									<input type="text" class="form-control" name="camp_contact_nom_hospitals" class="" placeholder="<?php esc_attr_e('Nom','doctreat');?>" value="<?php echo($_POST['camp_contact_nom_hospitals']);?>">
								</div>
								<div class="form-group form-group-half">
									<input type="text" class="form-control" name="camp_contact_prenom_hospitals" class="" placeholder="<?php esc_attr_e('Prénom','doctreat');?>" value="<?php echo($_POST['camp_contact_prenom_hospitals']);?>">
								</div>
								<div class="form-group form-group-half">
									<input type="email" class="form-control" name="camp_contact_email_hospitals" class="" placeholder="<?php esc_attr_e('E-mail','doctreat');?>" value="<?php echo($_POST['camp_contact_email_hospitals']);?>">
								</div>							
								<div class="form-group form-group-half">
									<input type="tel" class="form-control" name="camp_contact_tel_hospitals" class="" placeholder="<?php esc_attr_e('Téléphone','doctreat');?>" value="<?php echo($_POST['camp_contact_tel_hospitals']);?>">
								</div>
								
								<div class="form-group">
									<textarea name="" class="form-control" name="camp_contact_message_hospitals" placeholder="<?php esc_attr_e('Votre message ...','doctreat');?>"><?php echo($_POST['camp_contact_message_hospitals']);?></textarea>
								</div>
								<div class="form-group">
									<input type= "hidden" name="camp_contact_id_hospitals" value="<?php echo $post_id ;?>">			
									<input type= "submit" class="add-repeater-services dc-btn" style="border" value="<?php esc_attr_e('Envoyer','doctreat');?>">
								</div>
							</form>								
						</fieldset>
					</div> 						  
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	// Get the modal
	var modal = document.getElementById('myModal');

	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	  modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}
</script>