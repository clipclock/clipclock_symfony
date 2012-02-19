/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 16.02.12
 * Time: 19:18
 * To change this template use File | Settings | File Templates.
 */

current_scene_id = 0;
function embedClip(scene_time, video_id, source)
{
	preparePlayer(scene_time, video_id, source);
}

function preparePlayer(scene_time, video_id, source)
{
	if(source == 'youtube')
	{
		var params = { allowScriptAccess: "always", allowFullScreen: "true" };
		var atts = { id: "scene_embed_video_player" };
		swfobject.embedSWF("http://www.youtube.com/v/"+video_id+"?enablejsapi=1&playerapiid=ytplayer&start="+scene_time+"&autoplay=1&version=3&feature=player_embedded&fs=1&rel=0&showsearch=0&showinfo=0",
				'scene_embed_video', "640", "387", "8", null, null, params, atts);

		function onYouTubePlayerReady(playerId) {
			ytplayer = document.getElementById("scene_embed_video_player");
		}
	}

	newSceneTimeDescriptionContainer();
	newSceneTimeModalShow();
}

function seekTo(scene_time)
{
	ytplayer = document.getElementById("scene_embed_video_player");
	ytplayer.seekTo(scene_time-1);
}

function checkCurrentScene(scene_id, scene_time)
{
	seekTo(scene_time);

	if(current_scene_id != scene_id)
	{
		current_scene_id = scene_id;
		return true;
	}
	else
	{
		return false;
	}
}