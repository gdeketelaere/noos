<?php
/**
 * Template Name: Dashboard
 *
 * @package Doctreat
 * @since Doctreat 1.0
 * @desc Template used for front end dashboard.
 */
/* Define Global Variables */
global $current_user, $wp_roles, $userdata, $post, $theme_settings;

get_header();
$user_info = get_userdata($current_user->ID);
$user_roles= is_user_logged_in() ? implode(',', $user_info->roles) : '';
$user_roles=(string)$user_roles;

$user_identity 	= $current_user->ID;
$url_identity 	= !empty($_GET['identity']) ? intval($_GET['identity']) : '';

$post_id		= doctreat_get_linked_profile_id( $user_identity );
$is_verified 	= get_post_meta($post_id, '_is_verified', true);
$ref 			= !empty($_GET['ref']) ? esc_html( $_GET['ref'] ) : '';
$mode 			= !empty($_GET['mode']) ? esc_html( $_GET['mode'] ) : '';

if ( $user_roles === 'camp_member'){
	$user_type=$user_roles;	
}
else {
	$user_type	= apply_filters('doctreat_get_user_type', $user_identity );
}
$array_key_member=array('insights','profile-settings','account-settings','saved', 'references','logout');

$doctor_booking_option			= '';
if( function_exists( 'doctreat_get_booking_oncall_option' ) ) {
	$doctor_booking_option	= doctreat_get_booking_oncall_option();
}
if( have_posts() ) {
	while ( have_posts() ) : the_post();
	the_content();
	wp_link_pages( array(
		'before'      => '<div class="dc-paginationvtwo"><nav class="dc-pagination"><ul>',
		'after'       => '</ul></nav></div>',
		) );
	endwhile;
	wp_reset_postdata();
}

if ( is_user_logged_in() 
	&& ( $user_type === 'doctors' || $user_type === 'hospitals' || $user_type === 'regular_users' || $user_type === 'camp_member') ) {
		
	if ($user_type === 'camp_member'){
		$footer_copyright	= !empty( $theme_settings['copyright'] ) ? $theme_settings['copyright'] : esc_html__('Copyright','doctreat').' &copy; ' . date('Y') . '&nbsp;' . esc_html__('Doctreat. All rights reserved.', 'doctreat').get_bloginfo();
		ob_start();
		?>
		<div id="dc-sidebarwrapper" class="dc-sidebarwrapper">
			<div id="dc-btnmenutoggle" class="dc-btnmenutoggle">
				<i class="ti-arrow-right"></i>
			</div>
			<div id="dc-verticalscrollbar" class="dc-verticalscrollbar">
				<?php Doctreat_Profile_Menu::doctreat_do_process_userinfo(); ?>
				<nav id="dc-navdashboard" class="dc-navdashboard">
					<ul class="dashboard-menu-left">
					<?php					
						foreach($array_key_member as $key_member){
							get_template_part('directory/front-end/dashboard-menu-templates/profile-menu', $key_member);
						}					
					?>
					</ul>
				</nav>
				<?php if( !empty( $footer_copyright ) ){ ?>
					<div class="dc-navdashboard-footer">
						<span><?php echo do_shortcode( $footer_copyright );?></span>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php	
		echo ob_get_clean();	
		
	}else{
		Doctreat_Profile_Menu::doctreat_profile_menu_left(); 
	}	
			

	if( empty( $is_verified ) || $is_verified === 'no' ){
		$verify   = doctreat_get_signup_page_url('step', '1'); 
		?>
		  <div class="dc-haslayout dc-jobalertsdashboard">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
					<?php Doctreat_Prepare_Notification::doctreat_warning(esc_html__('Verification', 'doctreat'), esc_html__('Your account is not verified. Please verify your account', 'doctreat'),$verify,esc_html__('Verify', 'doctreat'));?>
				</div>
			</div>
		  </div>
	<?php }?>
	<section class="dc-haslayout dc-dbsectionspace">
		<div class="row">
			<?php
				
				if( !empty($ref) && $_GET['ref'] === 'profile' && $mode === 'settings' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'profile-settings');
				} elseif( $mode === 'educations') {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'profile-settings-educations');
				} elseif( $mode === 'awards' && $user_type!=='camp_member') {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'profile-settings-awards');
				} elseif( $mode === 'registrations' && $user_type!=='camp_member') {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'profile-settings-registrations');
				} elseif( $mode === 'location' && $user_type!=='camp_member') {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'profile-location');
				} elseif( $mode === 'gallery') {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'profile-gallery');
				} elseif( $mode === 'booking' && $user_type ==='doctors' && empty($doctor_booking_option)) {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'profile-booking-options');
				} else if( $user_type === 'doctors' && $ref === 'manage-article' && $mode === 'listings' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'manage-article');
				}  else if ( $user_type === 'doctors' && $ref === 'lastposts' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'lastposts');
				} else if ( $user_type === 'doctors' && $ref === 'camp-locations' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'camp-locations');
				}else if( $user_type === 'doctors' && $ref === 'appointment' && $mode === 'setting' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'appointment-setting');
				} else if( $user_type === 'doctors' && $ref === 'appointment' && $mode === 'location-settings' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'appointment-location-settings');
				} else if( $user_type === 'doctors' && $ref === 'appointment' && $mode === 'details' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'appointment-detials');
				} else if( $user_type === 'doctors' && $ref === 'appointment' && $mode === 'listing' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'appointment-listing');
				} else if ( $user_type === 'doctors' && !empty($ref) && $_GET['ref'] === 'package' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'packages');
				} else if ( $user_type === 'doctors' && !empty($ref) && $_GET['ref'] === 'invoices' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'invoices');
				} else if ( $user_type === 'doctors' && !empty($ref) && $_GET['ref'] === 'payouts' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/doctors/dashboard', 'payouts');
				} elseif( $user_type === 'doctors' && !empty( $ref ) && $ref === 'specialities' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'profile-settings-specialities');
				} else if( $user_type === 'hospitals' && $ref === 'team' && $mode === 'manage' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/hospitals/dashboard', 'team');
				} else if( $user_type === 'hospitals' && $ref === 'location' && $mode === 'details') {
					get_template_part('directory/front-end/templates/hospitals/dashboard', 'location-details');
				} elseif( $user_type === 'hospitals' && !empty( $ref ) && $ref === 'specialities' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'profile-settings-specialities');
				} else if( ($user_type === 'regular_users' || $user_type ==='camp_member') && $ref === 'appointment' && $mode === 'listing' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'appointment-listing');
				} else if ( ($user_type === 'regular_users' || $user_type ==='camp_member') && !empty($ref) && $_GET['ref'] === 'invoices' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'invoices');
				} else if ( !empty($ref) && $_GET['ref'] === 'account-settings' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'account-manage');
				} elseif ( !empty($ref) && $_GET['ref'] === 'saved' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'saved-items');
				} else if( !empty( $ref ) && $ref === 'chat' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'messaging');
				} elseif ( !empty($ref) && $_GET['ref'] === 'references' && ($url_identity === $user_identity) ) {
					get_template_part('directory/front-end/templates/dashboard', 'profile-references');
				}else{
					get_template_part('directory/front-end/templates/'.$user_type.'/dashboard', 'insights');
				}	
			?>
		</div>
	</section>
	<?php } else {?>
		<div class="container">
		 <div class="dc-haslayout page-data">
			<?php Doctreat_Prepare_Notification::doctreat_warning(esc_html__('Restricted Access', 'doctreat'), esc_html__('You have not any privilege to view this page.', 'doctreat'));?>
		  </div>
		</div>
<?php }
get_footer(); 