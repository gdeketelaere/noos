<?php
/**
 *
 * The template used for contacts details
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post,$theme_settings;
$post_id 	        = $post->ID;
$user_id            = doctreat_get_linked_profile_id($post_id,'post');
$user_detail        = !empty($user_id) ? get_userdata( $user_id ) : array();
$am_phone_numbers	= doctreat_get_post_meta( $post_id,'am_phone_numbers');
$am_web_url			= doctreat_get_post_meta( $post_id,'am_web_url');

$enable_options		= !empty($theme_settings['doctors_contactinfo']) ? $theme_settings['doctors_contactinfo'] : '';
$address		= get_post_meta( $post_id , '_address',true );
$address		= !empty( $address ) ? $address : '';
$latitude		= get_post_meta( $post_id , '_latitude',true );
$latitude		= !empty( $latitude ) ? $latitude : '';
$longitude		= get_post_meta( $post_id , '_longitude',true );
$longitude		= !empty( $longitude ) ? $longitude : '';


$am_availability	= doctreat_get_post_meta( $post_id,'am_availability');
$am_availability	= !empty( $am_availability ) ? $am_availability : '';

if( !empty( $am_availability ) && $am_availability === 'others' ) {
    $am_availability	= doctreat_get_post_meta( $post_id,'am_other_time');
} else if($am_availability === 'yes') {
    $am_availability	= esc_html__('24/7 available','doctreat');
}
$bookig_days		= doctreat_get_booking_days( $user_id ); 
$bookig_days		= !empty( $bookig_days ) ? $bookig_days : array();
$day				= strtolower(date('D'));
$availability       = '';
?>

<div class="dc-contactinfobox dc-locationbox">
    <?php if(!empty($latitude) && !empty($longitude)){?>
        <div class="dc-mapbox">
            <div id="location-pickr-map" class="dc-locationmap location-pickr-map" data-latitude="<?php echo esc_attr( $latitude );?>" data-longitude="<?php echo esc_attr( $longitude );?>"></div>
        </div>
    <?php } ?>
    <ul class="dc-contactinfo">
        <?php if(!empty($address)){?>
            <li>
                <i class="lnr lnr-location"></i>
                <address><?php echo esc_html($address); ?></address>
            </li>
        <?php } ?>
        <?php 
            if(!empty($am_phone_numbers) && !empty($enable_options) ){
                foreach($am_phone_numbers as $numbers){?>
                    <li>
                        <i class="lnr lnr-phone-handset"></i>
                        <sapn><a href="tell:<?php echo esc_attr($numbers); ?>"><?php echo esc_html($numbers); ?></a></span>
                    </li>
            <?php } ?>
        <?php } ?>
        <?php if(!empty($user_detail->user_email) && !empty($enable_options) ){?>
            <li>
                <i class="lnr lnr-envelope"></i>
                <span><a href="mailto:<?php echo esc_attr($user_detail->user_email); ?>?subject:<?php esc_html_e('Hello', 'doctreat'); ?>"><?php echo esc_html($user_detail->user_email); ?></a></span>
            </li>
        <?php } ?>
        <?php if (!empty($am_web_url) && !empty($enable_options) ) { ?>
            <li>
                <i class="lnr lnr-screen"></i>
                <span><a href="<?php echo esc_url($am_web_url); ?>" target="_blank"><?php echo esc_html($am_web_url); ?></a></span>
            </li>
        <?php } ?>
        
        <?php if( !empty( $bookig_days ) ){?>
                <li>
                    <i class="lnr lnr-clock"></i>
                    <span>
                        <?php 
                            $total_bookings	= count( $bookig_days );
                            $start			= 0;
                            foreach( $bookig_days as $val ){ 
                                $day_name	= doctreat_get_week_keys_translation($val);
                                $start ++;
                                if( $val == $day ){  
                                    $availability	= 'yes';
                                    echo '<em class="dc-dayon">'.ucfirst( $day_name ).'</em>'; 
                                } else {
                                    echo ucfirst( $day_name );
                                }
                                
                                if( $start != $total_bookings ) {
                                    echo ', ';
                                }
                            }
                        ?>
                    </span>
                </li>
        <?php } ?>
        <?php if( isset( $availability ) && !empty($bookig_days) ){?>
            <li>
                <i class="ti-wallet"></i>
                <span>
                <?php if( $availability === 'yes' ){ ?>
						<em class="dc-available"><?php esc_html_e('Available Today','doctreat');?></em>
					<?php } else{ ?>
						<em class="dc-dayon"><?php esc_html_e('Not Available','doctreat');?></em>
					<?php } ?>
                </span>
            </li>
        <?php } ?>
    </ul>
    <?php if (!empty($address)) { ?>
        <a class="dc-btn dc-btn-lg" href="//maps.google.com/maps?saddr=&amp;daddr=<?php echo esc_attr($address); ?>" target="_blank"><?php esc_html_e('Get Directions', 'doctreat'); ?></a>
    <?php } ?>
</div>

<?php
	$script = "jQuery(document).ready(function (e) {
				jQuery.doctreat_init_profile_map(0,'location-pickr-map', ". esc_js($latitude) . "," . esc_js($longitude) . ");
			});";
	wp_add_inline_script('doctreat-maps', $script, 'after');