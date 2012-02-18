
// Load the SDK Asynchronously
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function toggleFBLikeButton(scene_id, user_id, state, url) {
	$.ajax({
		url: url,
		type: "GET",
		data: { user_id : user_id, scene_id : scene_id, state: state }
	});
}

function fbHooks(scene_id, user_id, url)
{
	window.fbAsyncInit = function() {
		FB.init({
			appId      : 365665100128423,
			channelUrl : '//viddii.dev/channel.html',
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true  // parse XFBML
		});

		FB.Event.subscribe('edge.create',
				function(response) { toggleFBLikeButton(scene_id, user_id, 1, url); }
		);

		FB.Event.subscribe('edge.remove',
				function(response) { toggleFBLikeButton(scene_id, user_id, 0, url); }
		);

	};
}