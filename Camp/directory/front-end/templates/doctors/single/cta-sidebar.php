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
?>

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