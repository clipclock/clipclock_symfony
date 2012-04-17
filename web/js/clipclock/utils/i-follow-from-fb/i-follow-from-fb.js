
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
				if(object.type == 'video' && object.source.match(youtube_expr) && !object.link.match(clipclock_expr) && object.link)
				{

					var expr_result = youtube_replace_expr.exec(object.link);
					if(expr_result)
					{
						ajax_data.push(expr_result[1]);
					}
				}
			});

			console.log(ajax_data);
			$.ajax({
				url:ajax_url,
				data: {youtube_keys: ajax_data},
				success:function(response) {
					$(elem).prepend('<li>123</li>');
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
