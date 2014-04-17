/**
 * @package  Simple_Staff_Post_Type
 * @author   David Gale
 */

//Initialize fader to show individual staff
jQuery(document).ready( function() {
	jQuery('.thumb').mouseover(function () {
		jQuery(this).addClass('hover-staff-thumb');
	}).mouseout(function () {
		jQuery(this).removeClass('hover-staff-thumb');
	}).click(function() {
		jQuery('.thumb').removeClass('active-staff-thumb');
		jQuery(this).addClass('active-staff-thumb');
		var bio = jQuery(this).attr('id');
		if (jQuery('#' + bio + '-desc').hasClass('active-desc')) {
			// Do Nothing
		}
		else {
			jQuery('.active-desc').fadeOut(400, function() {
				jQuery(this).removeClass('active-desc');
				jQuery('#' + bio + '-desc').fadeIn(400);
				jQuery('#' + bio + '-desc').addClass('active-desc');
			});
		}
	});
});