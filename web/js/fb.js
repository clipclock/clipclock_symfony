
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

function fbHooks(app_id, scene_id, user_id, url)
{
	window.fbAsyncInit = function() {
		FB.init({
			appId      : app_id,
			channelUrl : '//dev.viddii.com/channel.html',
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true, // parse XFBML
			oauth: true
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

		function sendRequestToRecipients() {
			FB.ui({method: 'apprequests',
				message: 'Maksim Ustinov has invited you to join Pinterest, an online pinboard to organize and share your inspirations!',
				to: '100003277218703'
			}, function(){console.log('123')});
		}

		function sendRequestViaMultiFriendSelector() {
			FB.ui({method: 'apprequests',
				message: 'Maksim Ustinov has invited you to join Pinterest, an online pinboard to organize and share your inspirations!',
				filters: ["app_non_users"]
			}, function(response){console.log(response)});
		}
		$('#fb_invite').click(function(){
			sendRequestViaMultiFriendSelector();
			return false;
		});
	};
}