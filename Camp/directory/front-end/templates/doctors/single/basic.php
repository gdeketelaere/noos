<?php
/**
 *
 * The template used for doctors basics
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post,$theme_settings;
$post_id 	= $post->ID; 
$user_id	= doctreat_get_linked_profile_id( $post_id,'post' );
$verified	= get_post_meta($post_id, '_is_verified', true);
$verified	= !empty( $verified ) ? $verified	: '';

$system_access	= !empty($theme_settings['system_access']) ? $theme_settings['system_access'] : '';

$shoert_des		= doctreat_get_post_meta( $post_id, 'am_short_description');
$tagline		= doctreat_get_post_meta( $post_id, 'am_sub_heading');
$mrv			= doctreat_get_post_meta( $post_id, 'am_registration_number');
$name			= doctreat_full_name( $post_id );
$name			= !empty( $name ) ? $name : '';

$booking_option	= doctreat_get_booking_oncall_option('oncall');

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

$featured	= get_post_meta($post_id,'is_featured',true);


//Ajout Cyril K

$address		= get_post_meta( $post->ID , '_address',true );
$address		= !empty( $address ) ? $address : 'Paris';
$map = do_shortcode( '[camp_map]' );
//$map ='<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11376654.143867694!2d-6.932249111537538!3d45.881243114560725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd54a02933785731%3A0x6bfd3f96c747d9f7!2sFrance!5e0!3m2!1sfr!2sfr!4v1588783881376!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>';



?>
<div class="dc-docsingle-header">
	<?php if( !empty( $doctor_avatar ) ){?>
		<figure class="dc-docsingleimg">
			<img class="dc-ava-detail" src="<?php echo esc_url( $doctor_avatar );?>" alt="<?php echo esc_attr( get_the_title() );?>">
			<img class="dc-ava-detail-2x" src="<?php echo esc_url( $doctor_avatar_2x );?>" alt="<?php echo esc_attr( get_the_title() );?>">
			<?php if( !empty( $featured ) && intval($featured) > 0 ){ ?>
				<figcaption>
					<span class="dc-featuredtag"><i class="fa fa-bolt"></i></span>
				</figcaption>
			<?php } ?>
		</figure>
	<?php }?>
	<div class="dc-docsingle-content">
		<div class="dc-title">
			<h2>
				<a href="<?php echo esc_url( get_the_permalink() );?>"><?php echo esc_html( $name );?></a>
				<?php do_action('doctreat_get_drverification_check',$post_id,esc_html__('Education Verified','doctreat'));?>
				<?php do_action('doctreat_get_verification_check',$post_id,'');?>
			</h2>
			<div class="dc-docinfo">				
				<div><?php echo $map ;?></div>					
				<div>
					<i class="lnr lnr-location"></i><?php echo $address ;?>
				</div>				
			</div>
			<?php do_action('camp_specilities_list',$post_id);?>
			<?php do_action('camp_specilities_list',$post_id,'symtomes');?>			
		</div>
		<div class="dc-btnarea">
			<a href="#" class="dc-btn" id ="myBtn_contact"><?php _e('Contact','doctreat');?></a>
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
							<form action="" method="post">
		    					<?php wp_nonce_field( "action_camp_contact_doctors", "camp_contact_doctors", true, true );?>
								
								<div class="form-group form-group-half">
									<input type="text" class="form-control" name="camp_contact_nom_doctors" class="" placeholder="<?php esc_attr_e('Nom','doctreat');?>" value="<?php echo($_POST['camp_contact_nom_doctors']);?>">
								</div>
								<div class="form-group form-group-half">
									<input type="text" class="form-control" name="camp_contact_prenom_doctors" class="" placeholder="<?php esc_attr_e('Prénom','doctreat');?>" value="<?php echo($_POST['camp_contact_prenom_doctors']);?>">
								</div>
								<div class="form-group form-group-half">
									<input type="email" class="form-control" name="camp_contact_email_doctors" class="" placeholder="<?php esc_attr_e('E-mail','doctreat');?>" value="<?php echo($_POST['camp_contact_email_doctors']);?>">
								</div>							
								<div class="form-group form-group-half">
									<input type="tel" class="form-control" name="camp_contact_tel_doctors" class="" placeholder="<?php esc_attr_e('Téléphone','doctreat');?>" value="<?php echo($_POST['camp_contact_tel_doctors']);?>">
								</div>
								
								<div class="form-group">
									<textarea name="" class="form-control" name="camp_contact_message_doctors" placeholder="<?php esc_attr_e('Votre message ...','doctreat');?>"><?php echo($_POST['camp_contact_message_doctors']);?></textarea>
								</div>
								<div class="form-group">
									<input type= "hidden" name="camp_contact_id_doctors" value="<?php echo $post_id ;?>">			
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
	var btn = document.getElementById("myBtn_contact");

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