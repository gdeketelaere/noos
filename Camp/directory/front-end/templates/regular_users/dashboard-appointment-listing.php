<?php 
/**
 *
 * The template part for displaying appointment in listing
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */
?>
<?php
global $current_user, $post;
$user_identity 	 	= $current_user->ID;
$linked_profile  	= doctreat_get_linked_profile_id($user_identity);
$post_id 		 	= $linked_profile;

$date_format		= get_option('date_format');
$appointment_date 	= !empty( $_GET['appointment_date']) ? $_GET['appointment_date'] : date('Y-m-d');
$show_posts 		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$pg_page 			= get_query_var('page') ? get_query_var('page') : 1; 
$pg_paged 			= get_query_var('paged') ? get_query_var('paged') : 1;
$paged 				= max($pg_page, $pg_paged);
$order 	 			= 'DESC';
$sorting 			= 'ID';

$args = array(
	'posts_per_page' 	=> $show_posts,
    'post_type' 		=> 'booking',
    'orderby' 			=> $sorting,
    'order' 			=> $order,
	'author'			=> $user_identity,
	'post_status' 		=> array('publish','pending','cancelled'),
    'paged' 			=> $paged,
    'suppress_filters'  => false
);

if( !empty( $appointment_date ) ) {
	$meta_query_args[] = array(
							'key' 		=> '_appointment_date',
							'value' 	=> $appointment_date,
							'compare' 	=> '='
						);
	$query_relation 	= array('relation' => 'AND',);
	$args['meta_query'] = array_merge($query_relation, $meta_query_args);
}

$query 		= new WP_Query($args);
$count_post = $query->found_posts;

$width		= 40;
$height		= 40;
$flag 		= rand(9999, 999999);
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
	<div class="dc-dashboardbox dc-apointments-wrap dc-apointments-wraptest">	
		<form method="get" id="search_booking" action="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('appointment', $user_identity,'','listing');?>">
			<div class="dc-apointments-holder dc-apointments-holder-test">
				<div class="dc-appointment-calendar dc-appointment-calendartest">
					<div id="dc-calendar-app-<?php echo esc_attr( $flag );?>" class="dc-calendar"></div>
				</div>
				<div class="dc-appointment-border">
					<div class="dc-dashes">	
						<div class="dc-main-circle">
							<div class="dc-circle-raduis">
								<div class="rounded-circle dc-circle"></div>
							</div>
						</div>										
					</div>
				</div>
				<input type="hidden" id="search_appointment_date" name="appointment_date" value="<?php echo esc_attr($appointment_date);?>" >
				<input type="hidden" name="ref" value="appointment">
				<input type="hidden" name="mode" value="listing">
				<input type="hidden" name="identity" value="<?php echo intval($user_identity);?>">
				<div class="dc-recentapointdate-holder dc-recentapoint-test">
					<div class="dc-recentapointdate dc-recentapointdate-test">
						<h2><?php echo intval($count_post);?></h2>
						<span><?php esc_html_e('Appointments','doctreat');?><em><?php echo date( $date_format,strtotime( $appointment_date ) );?></em></span>
					</div>
				</div>
			</div>
		</form>
		<div class="dc-searchresult-head">
			<div class="dc-title"><h3><?php esc_html_e('Recent Apointments','doctreat');?></h3></div>
		</div>
		<?php if( $query->have_posts() ){ ?>
			<div class="dc-recentapoint-holder dc-recentapoint-holdertest">
				<?php
					while ($query->have_posts()) : $query->the_post(); 
						global $post;

						$doctor_id	= get_post_meta( $post->ID,'_doctor_id',true);
						$name		= doctreat_full_name( $doctor_id );
						$name		= !empty( $name ) ? $name : ''; 
						$thumbnail      = doctreat_prepare_thumbnail($doctor_id, $width, $height);
						$post_status	= get_post_status( $post->ID );
						$doctor_url		= get_the_permalink( $doctor_id );
						$doctor_url		= !empty( $doctor_url ) ? $doctor_url : '';
						$ap_date		= get_post_meta( $post->ID,'_appointment_date',true);
						$ap_date		= !empty( $ap_date ) ? strtotime($ap_date) : '';

						?>
						<div class="dc-recentapoint">
							<?php if( !empty( $ap_date ) ){?>
								<div class="dc-apoint-date">
									<span><?php echo date('d',$ap_date);?></span>
									<em><?php echo date('M',$ap_date);?></em>
								</div>
							<?php } ?>
							<div class="dc-recentapoint-content dc-apoint-noti dc-noti-colorone">
								<?php if( !empty( $thumbnail ) ){?>
									<a href="<?php echo esc_url( $doctor_url );?>">
										<figure><img src="<?php echo esc_url( $thumbnail );?>" alt="<?php echo esc_attr( $name );?>"></figure>
									</a>
								<?php } ?>
								<div class="dc-recent-content">
									<span><?php echo esc_html( $name );?> <em><?php esc_html_e( 'Status','doctreat');?>: <?php echo esc_html( $post_status );?></em></span>
									<a href="javascript:;" class="dc-btn dc-btn-sm" id="dc-booking-service" data-id="<?php echo intval($post->ID); ?>"><?php esc_html_e('View Details','doctreat');?></a>
								</div>
							</div>
						</div>
					<?php
						endwhile;
						wp_reset_postdata();
						if (!empty($count_post) && $count_post > $show_posts) {
							doctreat_prepare_pagination($count_post, $show_posts);
						}
					?>
			</div>
		<?php } else { ?>
			<?php do_action('doctreat_empty_records_html','dc-empty-booking dc-emptyholder-sm',esc_html__( 'There are no appointments booked.', 'doctreat' ));?>
		<?php } ?>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
	<div class="dc-dbsectionspacetest">
		<div class="dc-dashboardbox" id="dc-booking_service_details">
			
		</div>
	</div> 
</div>
<?php 
	$inline_script = "
	jQuery(document).on('ready', function() { 
		jQuery('#dc-calendar-app-".esc_js($flag)."').fullCalendar('render');
		jQuery('#dc-calendar-app-".esc_js($flag)."').fullCalendar({
			height: 'auto',
			dayClick: function(date, jsEvent, view) {
				var _date			= date.format();
				jQuery('#search_appointment_date').val(_date);
				jQuery('#search_booking').submit();
			}
		});
	});";
	wp_add_inline_script( 'doctreat-callback', $inline_script, 'after' );
	do_action('doctreat_booking_details');