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
	$('.clip_sticker').wookmark('update');
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
	$('#new_time_scene_modal').toggle();
	$('#shadow').toggle();

	new_time_scene_pause_player();
}

function newSceneTimeModalShow(scene_time_id, scene_text_id)
{
	$().ready(function(){

		$('#new_time_scene_modal input[type=reset]').click(function(){
			newSceneTimeModalHide();
		});
		$('#new_time_scene_modal .close').click(function(){
			newSceneTimeModalHide();
		});

		$('#new_time_scene_description_container_submit').click(function(){
			if($('#new_time_scene_description').val().length > 3)
			{
				if(getPlayer())
				{
					var player_time = getPlayer().getCurrentTime();
					$('#new_time_scene_modal #'+scene_time_id).val();
					var label_time = secondsToTime(player_time);
					$('#label_time').html(label_time.m+':'+label_time.s);
				}

				$('#new_time_scene_modal').toggle();
				$('#shadow').toggle();

				$('#new_time_scene_modal #'+scene_text_id).val($('#new_time_scene_description').val());
			}
			return false;
		});
	});
}

function new_time_scene_pause_player()
{
	ytplayer = getPlayer();
	if(ytplayer.getPlayerState() == 1 && !$('#scene_add_comment').hasClass('active'))
	{
		ytplayer.pauseVideo();
	}
	else if($('#scene_add_comment').hasClass('active'))
	{
		ytplayer.playVideo();
	}
	$('#scene_info').toggle();
	$('#scene_add_comment').toggleClass('active');
}

function secondsToTime(secs)
{
	var hours = Math.floor(secs / (60 * 60));

	var divisor_for_minutes = secs % (60 * 60);
	var minutes = Math.floor(divisor_for_minutes / 60);

	var divisor_for_seconds = divisor_for_minutes % 60;
	var seconds = Math.ceil(divisor_for_seconds);

	var obj = {
		"h": hours,
		"m": minutes,
		"s": seconds < 10 ? '0'+seconds : seconds
	};
	return obj;
}

function newSceneTimeDescriptionContainer()
{
	$().ready(function(){
		newSceneTimeModalShow('scene_time_scene_time', 'scene_time_scene_text');

		$('#new_time_scene').click(function(){
			new_time_scene_pause_player()
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
	var new_comment = $('#'+list_id+' div:first');
	if($(new_comment).is(":hidden"))
	{
		$(new_comment).slideDown("slow");
	}
}

function submitButton(submit_id, form_id)
{
	$().ready(function(){
		$('#'+submit_id).click(function(){
			$('#'+form_id).trigger('onsubmit');
			$('#comment_form').addClass('ajax_load');
			return false;
		});
	});
}