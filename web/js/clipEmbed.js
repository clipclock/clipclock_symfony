var ytplayer;
var redirectAterClose;

function preparePlayer(scene_time, video_id, source, modal, stop_and_auth)
{
	ytplayer = new YT.Player('scene_embed_video_player', {
		width:  (modal ? 541 : 640),
		height: 387,
		playerVars: {
			autoplay: 1,
			start: scene_time,
			wmode: "opaque"
		},
		videoId: video_id
	});

	newSceneTimeDescriptionContainer();
}

function embedClip(scene_time, video_id, source, modal, stop_and_auth)
{
	/*if(!stop_and_auth)
	{
		preparePlayer(scene_time, video_id, source, modal);
	}*/

	preparePlayer(scene_time, video_id, source, modal);
}

/*function preparePlayer(scene_time, video_id, source, modal)
{
	if(source == 'youtube')
	{
		var params = { allowScriptAccess: "always", allowFullScreen: "true", wmode: 'transparent' };
		var atts = { id: "scene_embed_video_player" };
		swfobject.embedSWF("http://www.youtube.com/v/"+video_id+"?enablejsapi=1&playerapiid=ytplayer&start="+scene_time+"&autoplay=1&version=3&feature=player_embedded&fs=1&rel=0&showsearch=0&showinfo=0",
				'scene_embed_video', modal ? "541" : "640", "387", "8", null, null, params, atts);

		function onYouTubePlayerReady(playerId) {
			ytplayer = getPlayer();
		}
	}

	newSceneTimeDescriptionContainer();
	//newSceneTimeModalShow();
}*/

function getPlayer()
{
	//return document.getElementById("scene_embed_video_player");
	return ytplayer;
}

function seekTo(scene_time)
{
	ytplayer.seekTo(scene_time);
	if (ytplayer.getPlayerState() == YT.PlayerState.PAUSED)
		ytplayer.playVideo();
}

function checkCurrentScene(scene_id, scene_time)
{
	seekTo(scene_time);
	highliteControlTab(scene_id);


	if($('#scene_add_comment').hasClass('active'))
	{
		new_time_scene_pause_player();
		showSceneDescription(scene_id);
	}

	if(current_scene_id != scene_id)
	{
		current_scene_id = scene_id;
		toggleAjaxLoader();
		return true;
	}
	else
	{
		return false;
	}
}