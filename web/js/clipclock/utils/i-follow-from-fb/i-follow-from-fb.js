
$(function(){

	var appendFromFB = function(elem, ajax_url){

		$.ajax({
			url:ajax_url,
			success:function(response) {
				console.log(response);
				$(response).each(function(i, new_elem){
					$(elem).prepend(new_elem);
				});
				$('.clip_sticker').wookmark('update');

				if($(response).length)
				{
					appendFromFB(elem, $(elem).attr('data-i-follow-from-fb'));
				}
			}
		});
	};

	$('.stickers-list').each(function(i, elem){
		if($(elem).attr('data-i-follow-from-fb'))
		{
			appendFromFB(elem, $(elem).attr('data-i-follow-from-fb'));
		}
	});
});
