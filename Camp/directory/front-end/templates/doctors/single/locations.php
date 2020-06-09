<?php

/**
 *
 * The template used for doctors locations
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post;
$post_id     = $post->ID;
$name        = doctreat_full_name($post_id);
$name        = !empty($name) ? $name : '';
$author_id     = doctreat_get_linked_profile_id($post_id, 'post');

$show_posts     = get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$pg_page         = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged         = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
$paged             = max($pg_page, $pg_paged);
$order             = 'DESC';
$sorting         = 'ID';

$args             = array(
    'posts_per_page'     => $show_posts,
    'post_type'         => 'hospitals_team',
    'orderby'             => $sorting,
    'order'             => $order,
    'post_status'         => array('publish'),
    'author'             => $author_id,
    'paged'             => $paged,
    'suppress_filters'     => false
);
$query                 = new WP_Query($args);
$count_post         = $query->found_posts;


?>
<div class="dc-location-holder tab-pane" id="locations">
    <div class="dc-searchresult-holder">
        <div class="dc-searchresult-head">
            <div class="dc-title">
                <h3>“<?php echo esc_html($name); ?>” <?php esc_html_e('Locations', 'doctreat'); ?></h3>
            </div>
        </div>
        <div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo">
            <?php if ($query->have_posts()) {
                while ($query->have_posts()) : $query->the_post();
                    global $post;
                    $hospital_id    = get_post_meta($post->ID, 'hospital_id', true);

                    if (!empty($hospital_id)) {
                        $post->ID        = $hospital_id;
                        get_template_part('directory/front-end/templates/hospitals/hospitals-listing');
                    }
                endwhile;
                wp_reset_postdata();

                if (!empty($count_post) && $count_post > $show_posts) {
                    doctreat_prepare_pagination($count_post, $show_posts);
                }
            } else {
                do_action('doctreat_empty_records_html', 'dc-empty-hospital-location dc-emptyholder-sm', esc_html__('No Available hospitals Locations.', 'doctreat'));
            } ?>
        </div>
    </div>
    <br/>
    <div class="dc-searchresult-holder">
        <div class="dc-searchresult-head">
            <div class="dc-title">
                <h3>“<?php echo esc_html($name); ?>” <?php esc_html_e('Custom Locations', 'doctreat'); ?></h3>
            </div>
        </div>
        <div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo">
            <?php
            if (get_post_meta($post_id, '_camp_custom_locations', true)) :
                $locations = get_post_meta($post_id, '_camp_custom_locations', true);
                foreach ($locations as $key => $location) :

                    $city = $location['city'];
                    $address = $location['address'];
                    $logitude = $location['longitude'];
                    $latitude = $location['latitude'];
                    $image_url = $location['image'];
                    $days_offer = !empty($location['days_offer']) ? $location['days_offer'] : array();

            ?>
           
                    <div class="dc-docpostholder">
                        <div class="dc-docpostcontent">
                            <div class="dc-searchvtwo" style="max-width: 100%; padding: 10px;">
                                <figure class="dc-docpostimg">
                                    <img class="dc-image-res" src="<?php echo $image_url; ?>" alt="<?php echo $address; ?>">
                                    <img class="dc-image-res-2x" src="<?php echo $image_url; ?>" alt="<?php echo $address; ?>">
                                </figure>
                                <div class="dc-title">
                                    <h3><?php esc_html_e('Address', 'doctreat'); ?></h3>
                                    <p><?php echo $address; ?></p>
                                   <!-- <ul class="dc-docinfo">
                                        <?php if (!empty($days_offer)) :
                                            foreach ($days_offer as $key2 => $day_offer) : ?>
                                                <li>
                                                    <i class="lnr lnr-clock"></i>
                                                    <?php echo ucfirst($key2) . '  :  '; ?>
                                                    <em><?php if ($day_offer["start_time"] !== $day_offer["end_time"]) {
                                                            echo $day_offer["start_time"] . ' - ' . $day_offer["end_time"];
                                                        } else {
                                                            echo "24h/24";
                                                        } ?></em></li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>-->
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                endforeach;
            else :
                do_action('doctreat_empty_records_html', 'dc-empty-articls dc-emptyholder-sm', esc_html__('No Available custom Locations.', 'doctreat'));
            endif;
            ?>
        </div>

    </div>
</div>