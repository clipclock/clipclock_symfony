/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 16.02.12
 * Time: 19:18
 * To change this template use File | Settings | File Templates.
 */

current_scene_id = 0;
function embedClip(container_id, scene_time, video_id, source)
{
	player_container_id = container_id + '_player';
	preparePlayer(container_id, player_container_id, scene_time, video_id, source);
}

function preparePlayer(container_id, player_container_id, scene_time, video_id, source)
{
	if(source == 'youtube')
	{
		var params = { allowScriptAccess: "always", allowFullScreen: "true" };
		var atts = { id: player_container_id };
		swfobject.embedSWF("http://www.youtube.com/v/"+video_id+"?enablejsapi=1&playerapiid=ytplayer&start="+scene_time+"&autoplay=1&version=3&feature=player_embedded&fs=1&rel=0&showsearch=0&showinfo=0",
				container_id, "640", "387", "8", null, null, params, atts);

		function onYouTubePlayerReady(playerId) {
			ytplayer = document.getElementById(player_container_id);
		}
	}

	_newSceneTime(player_container_id);
}

function seekTo(scene_time)
{
	ytplayer = document.getElementById(player_container_id);
	ytplayer.seekTo(scene_time);
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