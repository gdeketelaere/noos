<?php

/**

 *

 * The template used for doctors navigation style

 *

 * @package   doctreat

 * @author    amentotech

 * @link      https://amentotech.com/user/amentotech/portfolio

 * @version 1.0

 * @since 1.0

 */
?>
<div class="dc-docsingle-navholder">
<div class="container">
		<div class="row">
<ul class="dc-navdocsingletab nav navbar-nav">
            <li class="nav-item">

              <a id="userdetails-tab" class="active" data-toggle="tab" href="#userdetails"><?php esc_html_e('Description','doctreat');?></a>

            </li>
            <?php if( empty($system_access) ){ ?>

                <li class="nav-item">

                    <a data-toggle="tab" href="#locations"><?php esc_html_e('Locations','doctreat');?></a>

                </li>

            <?php } ?>

            <li class="nav-item">

            <a id="comments-tab" data-toggle="tab" href="#campservices"><?php esc_html_e('Sessions','doctreat');?></a>

            </li>

            <li class="nav-item">

                <a id="articles-tab" data-toggle="tab" href="#stories"><?php esc_html_e('Stories','doctreat');?></a>

            </li>

            <li class="nav-item">

                <a id="feedback-tab" data-toggle="tab" href="#community"><?php esc_html_e('Community','doctreat');?></a>

            </li>


            <li class="nav-item">

                <a id="articles-tab" data-toggle="tab" href="#feedback"><?php esc_html_e('Reviews','doctreat');?></a>

            </li>


        </ul>
        </div></div></div>

<script>
// Select all links with hashes
jQuery('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {

      var target = jQuery(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

      if (target.length) {

        event.preventDefault();
        var posY = target.offset().top;
        jQuery('html, body').animate({
          scrollTop: posY - 150
        }, 1000, function() {

          var $target = jQuery(target);
          //$target.focus();
          if ($target.is(":focus")) { 
            return false;
          } else {
            $target.attr('tabindex','-1'); 
            //$target.focus(); 
          };
        });
      }
    }
  });
</script>