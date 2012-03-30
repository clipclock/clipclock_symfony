var fb_already_inited = false;
// Load the SDK Asynchronously
$().ready(function(){
	var d = document;
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
});

function toggleFBLikeButton(scene_id, user_id, state, url) {
	$.ajax({
		url: url,
		type: "GET",
		data: { user_id : user_id, scene_id : scene_id, state: state }
	});
}

function fbHooks(app_id, scene_id, user_id, url, requests_url)
{
	if(!fb_already_inited)
	{
		window.fbAsyncInit = function() {
			fbHooksRoutine(app_id, scene_id, user_id, url, requests_url);
			fb_already_inited = true;
		};
	}
	else
	{
		fbHooksRoutine(app_id, scene_id, user_id, url, requests_url);
	}
}


function fbHooksRoutine(app_id, scene_id, user_id, url, requests_url)
{
		FB.init({
			appId      : app_id,
			channelUrl : '//clipclock.com/channel.html',
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true, // parse XFBML
			oauth: true,
			frictionlessRequests : true
		});

		if(scene_id && user_id && url)
		{
			FB.Event.subscribe('edge.create',
					function(response) { toggleFBLikeButton(scene_id, user_id, 1, url); }
			);

			FB.Event.subscribe('edge.remove',
					function(response) { toggleFBLikeButton(scene_id, user_id, 0, url); }
			);
		}

		function sendRequestViaMultiFriendSelector() {
			FB.ui({method: 'apprequests',
				message: 'Ask friends to comment your video clips!',
				filters: ["app_non_users"]
			}, function(response){
				$.ajax({
					url: requests_url,
					type: "POST",
					data: {result: response},
					/*beforeSend: function(){highliteControlTab(scene_id);seekTo(secs);},*/
					success: function(result){
						$.each(response.to, function(index, value){
							_kmq.push(['record', 'Invited friend', {'Where':'facebook', 'friend':value}]);
						});
					}
				});
			});
		}

		function sendRequestViaMultiFriendSelectorMany() {
			var user_ids = [];
			FB.api('/me/friends', function(response) {
				$(response.data).each(function(index, value){
					user_ids.push(value.id);
				});
				function randOrd(){
					return (Math.round(Math.random())-0.5); }
				user_ids = user_ids.sort( randOrd );
				FB.ui({method: 'apprequests',
					message: 'Ask friends to comment your video clips!',
					filters: ["app_non_users"],
					to: user_ids.slice(0, 50)
				}, function(response){
					$.ajax({
						url: requests_url,
						type: "POST",
						data: {result: response},
						/*beforeSend: function(){highliteControlTab(scene_id);seekTo(secs);},*/
						success: function(result){
							$.each(response.to, function(index, value){
								_kmq.push(['record', 'Invited friend', {'Where':'facebook', 'friend':value}]);
							});
						}
					});
				});
			});
			return false;
		}

		$('#fb_invite').click(function(){
			sendRequestViaMultiFriendSelector();
			return false;
		});

		$('#fb_invite_many').click(function(){
			sendRequestViaMultiFriendSelectorMany();
			return false;
		});
}