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

$name			= doctreat_full_name( $post_id );
$name			= !empty( $name ) ? $name : '';


$doctor_avatar = apply_filters(
					'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar( array( 'width' => 255, 'height' => 250 ), $post_id ), array( 'width' => 255, 'height' => 250 )
				);

$doctor_avatar_2x = apply_filters(
					'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar( array( 'width' => 545, 'height' => 428 ), $post_id ), array( 'width' => 545, 'height' => 428 )
				);

$featured	= get_post_meta($post_id,'is_featured',true);


//Ajout Cyril K
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
			<?php// do_action('doctreat_specilities_list',$post_id,1);?>
			<h2>
				<a href="<?php echo esc_url( get_the_permalink() );?>"><?php echo esc_html( $name );?></a>				
			</h2>
		</div>
		<div class="dc-btnarea">
			<!--a href="javascript:;" data-id="<?php //echo intval( $post_id );?>" class="dc-btn dc-add-feedback"><?php //esc_html_e('Add Feedback','doctreat');?></a-->
			<a href="#" class="dc-btn" id ="myBtn"><?php esc_html_e('Contact','doctreat');?></a>				
			<a href="#" class="dc-btn"><?php esc_html_e('Enrégistrer','doctreat');?></a>
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
		    					<?php wp_nonce_field( "action_camp_contact_camp_member", "camp_contact_camp_member", true, true );?>		    						
								<div class="form-group form-group-half">
									<input type="text" class="form-control" name="camp_contact_nom_camp_member" class="" placeholder="<?php esc_attr_e('Nom','doctreat');?>" value="<?php echo($_POST['camp_contact_nom_camp_member']);?>">
								</div>
								<div class="form-group form-group-half">
									<input type="text" class="form-control" name="camp_contact_prenom_camp_member" class="" placeholder="<?php esc_attr_e('Prénom','doctreat');?>" value="<?php echo($_POST['camp_contact_prenom_camp_member']);?>">
								</div>
								<div class="form-group form-group-half">
									<input type="email" class="form-control" name="camp_contact_email_camp_member" class="" placeholder="<?php esc_attr_e('E-mail','doctreat');?>" value="<?php echo($_POST['camp_contact_email_camp_member']);?>">
								</div>							
								<div class="form-group form-group-half">
									<input type="tel" class="form-control" name="camp_contact_tel_camp_member" class="" placeholder="<?php esc_attr_e('Téléphone','doctreat');?>" value="<?php echo($_POST['camp_contact_tel_camp_member']);?>">
								</div>
								
								<div class="form-group">
									<textarea name="" class="form-control" name="camp_contact_message_camp_member" placeholder="<?php esc_attr_e('Votre message ...','doctreat');?>"><?php echo($_POST['camp_contact_message_camp_member']);?></textarea>
								</div>
								<div class="form-group">
									<input type= "hidden" name="camp_contact_id_camp_member" value="<?php echo $post_id ;?>">			
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