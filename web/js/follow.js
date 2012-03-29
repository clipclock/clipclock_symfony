/**
 * Created by JetBrains PhpStorm.
 * User: lmaxim
 * Date: 2/25/12
 * Time: 4:02 PM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){
	bindFollow();
});

function bindFollow()
{
	$('.ajax-button').click(function() {
		var button = $(this);
		$.ajax({
			url: $(this).attr('href'),
			type: "GET",
			dataType: 'json',
			success: function(data, textStatus, jqXHR) {
				if (data.result == 'success')
				//$(button).parent().find('.ajax-button').each(function(){ $(this).toggleClass('hidden') });
					$('a[href="' + $(button).attr('href') + '"]')
							.each(function(){ $(this).parent().find('.ajax-button').each(function(){ $(this).toggleClass('hidden') }); });
			}


		});
		return false;
	});
}