/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 15.02.12
 * Time: 18:18
 * To change this template use File | Settings | File Templates.
 */
function stickerChange(data, clip_id)
{
	var data = JSON.parse(data);
	$('#image_'+clip_id).html(data.scene_image);
	$('#comments_list_'+clip_id).html(data.scene_comments_list);
}

function sceneChange(data)
{
	var data = JSON.parse(data);
	$('#description').html(data.scene_image);
	$('#comment_form').html(data.scene_comment_form);
	$('#comments').html(data.scene_description);
	$('#fun_buttons').html(data.scene_social_buttons);
	$('#people_sticker').html(data.scene_people_sticker);
}

function _newSceneTime(player_container_id)
{
	$().ready(function(){
		$('#new_time_scene').click(function(){
			ytplayer = document.getElementById(player_container_id);
			console.log(ytplayer.getCurrentTime());
		});
	});
}