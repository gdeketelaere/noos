<?php
/**
 *
 * The template used for doctors post style
 *
 * @package   doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

get_header();
global $theme_settings,$current_user;
$booking_option		= doctreat_theme_option();
$system_access		= !empty( $theme_settings['system_access'] ) ? $theme_settings['system_access'] : '';
if(  is_active_sidebar( 'doctor-sidebar-right' ) ){ 
	$section_width     	= 'col-12 col-lg-12 col-xl-9';
} else {
	$section_width     	= 'col-12';
}
$doctor_user_id	= '';
while ( have_posts() ) {
	the_post();
	global $post;
	$width			= 271;
	$height			= 194;
	$thumbnail      = doctreat_prepare_thumbnail($post->ID, $width, $height);
	$doctor_user_id	= doctreat_get_linked_profile_id($post->ID,'post');
	?>
	<div class="dc-haslayout dc-parent-section">
		<div class="container">
			<div class="row">
				<div id="dc-twocolumns" class="dc-twocolumns dc-haslayout">
					<div class="<?php echo esc_attr($section_width);?> float-left">
						<?php get_template_part('directory/front-end/templates/camp_member/single/basic'); ?>
						<div class="dc-docsingle-holder">
							<ul class="dc-navdocsingletab nav navbar-nav">
								
								<li class="nav-item">
									<a id="userdetails-tab" class="active" data-toggle="tab" href="#userdetails"><?php esc_html_e('Description','doctreat');?></a>
								</li>
								
								<li class="nav-item">
									<a id="articles-tab" data-toggle="tab" href="#articles"><?php esc_html_e('Community','doctreat');?></a>
								</li>
								
							</ul>
							<div class="tab-content dc-contentdoctab dc-haslayout">
								
								<?php get_template_part('directory/front-end/templates/camp_member/single/userdetails'); ?>								
								<?php get_template_part('directory/front-end/templates/camp_member/single/articles'); ?>
								
							</div>
						</div>
					</div>
					<?php if(  is_active_sidebar( 'doctor-sidebar-right' ) ){ ?>
						<div class="col-12 col-md-6 col-lg-6 col-xl-3 float-left">
							<aside id="dc-sidebar" class="dc-sidebar dc-sidebar-grid float-left mt-xl-0">
							<?php
								if(  is_active_sidebar( 'doctor-sidebar-right' ) ){ 
									get_template_part('directory/front-end/templates/doctors-location-sidebar');
									dynamic_sidebar( 'doctor-sidebar-right' );
								}
							?>
							</aside>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php
if ( is_user_logged_in() ) {
	$url_identity 	 = $current_user->ID;
	$user_type	= apply_filters('doctreat_get_user_type', $url_identity );
	if( ( !empty($doctor_user_id) && !empty( $user_type )  && ( $user_type === 'doctors' && apply_filters('doctreat_is_feature_allowed', 'dc_chat', $doctor_user_id) === true ) )
	|| $user_type === 'hospitals' 
	|| $user_type === 'regular_users'
	) {
		get_template_part('directory/front-end/templates/messages'); 
	}
	get_template_part('directory/front-end/templates/doctors/single/addfeedback');
}

get_template_part('directory/front-end/templates/doctors/single/bookings'); 
$script = "
	dcModal();
	jQuery(document).on('ready', function() {
		dcModal();
	});
";
}
get_footer(); 