
$(function(){

	var appendFromFB = function(elem, ajax_url){

		FB.api('/me/home/', {limit: 200}, function(response)
		{
			var youtube_expr = /http\:\/\/(www.)?youtube\.com*/i;
			var clipclock_expr = /http\:\/\/(www.)?clipclock\.com*/i;
			var youtube_replace_expr = /v=(\w+)/i;
			var ajax_data = [];
			response.data.forEach(function(object)
			{
				//console.log(object);
				if(object.type == 'video' && object.source.match(youtube_expr) && !object.link.match(clipclock_expr) && object.link)
				{

					var expr_result = youtube_replace_expr.exec(object.link);
					if(expr_result)
					{
						var post_id = object.id.replace(object.from.id+'_', '');//facebook page id trick (id=userId_postId)
						ajax_data.push(new Array(expr_result[1], object.from, object.created_time, object.message ? object.message : '', post_id));
					}
				}
			});

			$.ajax({
				url:ajax_url,
				data: {clip_keys: ajax_data},
				success:function(response) {
					$(response).each(function(i, new_elem){
						$(elem).prepend(new_elem);
					});
					$('.clip_sticker').wookmark('update');
				}
			});
		});
	};

	$('.stickers-list').each(function(i, elem){
		if($(elem).attr('data-i-follow-from-fb'))
		{
			asyncRequestor.call('facebook', function(){
				FB.Event.subscribe('auth.statusChange', function(response){appendFromFB(elem, $(elem).attr('data-i-follow-from-fb'))});
			});
		}
	});
});
