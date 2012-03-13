//sfAdminThemePlugin javascript

var image_dir = '../images/sf_admin/';

//if new button exists, edit it
/*jQuery(function() {
  if (jQuery('.sf_admin_action_new').size()) {
    jQuery('.sf_admin_action_new a').prepend("<img src='" + image_dir + "new_f2.png" + "' alt='New' /><br />");
  }
});*/

//menu
jQuery(function(){
		jQuery('li.node').hover(
			function() {
        jQuery('ul', this).css('display', 'block');
        jQuery(this).addClass('nodehover');
      },
			function() {
        jQuery('ul', this).css('display', 'none');
        jQuery(this).removeClass('nodehover');
      });

    jQuery('li.node a[href=#]').click(function() {
      return false;
    });
	});
