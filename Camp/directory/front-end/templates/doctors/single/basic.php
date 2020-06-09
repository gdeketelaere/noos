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
	<div class="container">
		<div class="row">

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

							<div class="dc-docinfo-location">

								<img class="dc-icon--small" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/map-pointer.svg'; ?> "/><?php echo $address ;?>

							</div>				

						</div>

						<div class="dc-docinfo-specialities">
							<?php do_action('camp_specilities_list',$post_id);?>
						</div>
						
						<div class="dc-docinfo-specialities">
							<?php do_action('camp_specilities_list',$post_id,'symtomes');?>	
						</div>	

					</div>

				</div>
				
			</div>

		</div>
		<?php get_template_part('directory/front-end/templates/doctors/single/navigation'); ?>
	</div>

</div>

<script>
	// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("dc-main");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>