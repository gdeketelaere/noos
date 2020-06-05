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

            <?php if( empty($system_access) ){ ?>

                <li class="nav-item">

                    <a data-toggle="tab" href="#locations"><?php esc_html_e('Available Locations','doctreat');?></a>

                </li>

            <?php } ?>

            <li class="nav-item">

                <a id="userdetails-tab" class="active" data-toggle="tab" href="#userdetails"><?php esc_html_e('Doctor Details','doctreat');?></a>

            </li>

            <li class="nav-item">

                <a id="comments-tab" data-toggle="tab" href="#comments"><?php esc_html_e('Online Consultation','doctreat');?></a>

            </li>

            <li class="nav-item">

                <a id="feedback-tab" data-toggle="tab" href="#feedback"><?php esc_html_e('Feedback','doctreat');?></a>

            </li>

            <li class="nav-item">

                <a id="articles-tab" data-toggle="tab" href="#articles"><?php esc_html_e('Articles','doctreat');?></a>

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
      // Figure out element to scroll to
      var target = jQuery(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        jQuery('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = jQuery(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });
</script>