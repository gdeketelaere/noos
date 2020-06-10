<?php

/**
 *
 * The template used for doctors details skills
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post, $theme_settings;
$post_id         = $post->ID;
$name            = doctreat_full_name($post_id);
$name            = !empty($name) ? $name : '';

$width            = 271;
$height            = 194;
$thumbnail      = doctreat_prepare_thumbnail($post->ID, $width, $height);
$gallery_option    = !empty($theme_settings['enable_gallery']) ? $theme_settings['enable_gallery'] : '';
$_href_see_more = $_SESSION['_href_see_more'];
$_href_see_more = !empty($_href_see_more) ? $_href_see_more : 0;
$_class = $_href_see_more == 1 ? 'fade' : 'active';
?>
<div class="dc-skills-holder  tab-pane" id="skills">


    <div class="dc-aboutdoc dc-aboutinfo">
        <div class="dc-infotitle">
            <h3><?php esc_html_e('Skills & Endorsements', 'doctreat'); ?></h3>
        </div>
    </div>

    <div class="dc-specialitieslist dc-skillslist">
        <div class="dc-infotitle">

            <h3><img class="dc-icon--small" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/skill.svg';?> "> Specialities</h3>

        </div>
        <div class="dc-docinfo-specialities">
            <?php do_action('camp_specilities_list', $post_id, 'specialities', 100);?>
        </div>
    </div>
    
    <div class="dc-specialitieslist dc-skillslist">
        <div class="dc-infotitle">

            <h3><img class="dc-icon--small" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/skill.svg';?> "> Symptoms</h3>

        </div>
        <div class="dc-docinfo-specialities">
            <?php do_action('camp_specilities_list',$post_id, 'symtomes', 100);?>	
        </div>	
    </div>

    <?php get_template_part('directory/front-end/templates/doctors/single/experience'); ?>
    <?php get_template_part('directory/front-end/templates/doctors/single/education'); ?>
    <?php get_template_part('directory/front-end/templates/doctors/single/awards'); ?>
</div>