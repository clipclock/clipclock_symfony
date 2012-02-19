/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 15.02.12
 * Time: 18:18
 * To change this template use File | Settings | File Templates.
 */
function stickerChange(data, clip_id, scene_id)
{
	var data = JSON.parse(data);
	$('#image_'+clip_id).html(data.scene_image);
	$('#comments_list_'+clip_id).html(data.scene_comments_list);
	$('#comments_list_footer_'+clip_id).html(data.scene_footer);
	$('#clip_control_'+clip_id+' li').removeClass('active');
	$('#sticker_'+clip_id+'_'+scene_id).addClass('active');
}

function sceneChange(data)
{
	var data = JSON.parse(data);
	$('#description').html(data.scene_description);
	$('#comment_form').html(data.scene_comment_form);
	$('#comments').html(data.scene_comments_list);
	$('#fun_buttons').html(data.scene_social_buttons);
	$('#people_sticker').html(data.scene_people_sticker);
}

function newSceneTimeModalHide()
{
	$('#new_time_scene_description_container').toggle();
	$('#new_time_scene_modal').toggle();
	ytplayer = document.getElementById("scene_embed_video_player");
	ytplayer.playVideo();
}

function newSceneTimeModalShow()
{
	$('#new_time_scene_description_container_submit').click(function(){
		if($('#new_time_scene_description').val().length > 3)
		{
			$('#new_time_scene_modal').toggle();
			$('#shadow').toggle();

			ytplayer = document.getElementById("scene_embed_video_player");
			$('#new_time_scene_modal #scene_time_scene_time').val(ytplayer.getCurrentTime());
			$('#new_time_scene_modal #scene_time_scene_text').val($('#new_time_scene_description').val());
		}
		return false;
	});
}

function newSceneTimeDescriptionContainer()
{
	$().ready(function(){
		$('#new_time_scene').click(function(){
			$('#scene_info').toggle();
			$('#scene_add_comment').toggleClass('active');
			ytplayer = document.getElementById("scene_embed_video_player");
			if(ytplayer.getPlayerState() == 1)
			{
				ytplayer.pauseVideo();
			}
			else
			{
				ytplayer.playVideo();
			}
			newSceneTimeModalShow();
			return false;
		});
	});
}

function checkCommentForm(textarea_id)
{
	return $('#comment_form form textarea').val() ? true : false;
}

function prependNewComments(data, list_id)
{
	var data = JSON.parse(data);
	$('#'+list_id).prepend(data.scene_new_comment);
}

function submitButton(submit_id, form_id)
{
	$().ready(function(){
		$('#'+submit_id).click(function(){
			$('#'+form_id).trigger('onsubmit');
			return false;
		});
	});
}