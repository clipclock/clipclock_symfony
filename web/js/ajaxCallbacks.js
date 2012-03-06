/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 15.02.12
 * Time: 18:18
 * To change this template use File | Settings | File Templates.
 */
current_scene_id = 0;
first_scene = null;
function stickerChange(data, clip_id, scene_id)
{
	var data = JSON.parse(data);
	$('#image_'+clip_id).html(data.scene_image);
	$('#comments_list_'+clip_id).html(data.scene_comments_list);
	$('#comments_list_footer_'+clip_id).html(data.scene_footer);
	$('#clip_control_'+clip_id+' li').removeClass('active');
	$('#sticker_'+clip_id+'_'+scene_id).addClass('active');
	toggleAjaxLoader('_'+clip_id);
	$('.clip_sticker').wookmark('update');
}

function checkCurrentSticker(clip_id, scene_id)
{
	toggleAjaxLoader('_'+clip_id);

	return true;
}

function toggleAjaxLoader(elem_id)
{
	if(!elem_id)
	{
		elem_id = '';
	}
	$('.ajax_toogle'+elem_id).toggleClass('ajax_hider');
	$('.ajax_toogle_container'+elem_id).toggleClass('ajax_loader');
}

function sceneChange(json_data, dont_history, url, json_url, secs, scene_id)
{
	var data = JSON.parse(json_data);
	$('#description').html(data.scene_description);
	$('#comment_form').html(data.scene_comment_form);
	$('#comments').html(data.scene_comments_list);
	$('#fun_buttons').html(data.scene_social_buttons);
	$('#people_sticker').html(data.scene_people_sticker);
	$('#nav_path').html(data.nav_path);
	$('#nav_avatar').html(data.nav_avatar);
	bindCommentRatingButtons(data.rating_url);
	toggleAjaxLoader();

	if(!dont_history)
	{
		history.pushState({json_url: json_url, secs: secs, scene_id: scene_id}, 'Title', url);
	}
}

function bindSceneChangeBack(json_url, secs, scene_id)
{
	$().ready(function(){
		window.addEventListener('popstate', function(e){
			if(e.state)
			{
				json_url = e.state.json_url;
				secs = e.state.secs;
				scene_id = e.state.scene_id;
			}
			else if(first_scene)
			{
				scene_id = first_scene.scene_id;
				secs = first_scene.secs;
				json_url = first_scene.json_url;
			}

			if(first_scene)
			{
				$.ajax({
					url: json_url,
					beforeSend: function(){highliteControlTab(scene_id);seekTo(secs);},
					dataType: 'text',
					success: function(data){
						sceneChange(data, true);
					}
				});
				scene_id = null;
				secs = null;
				json_url = null;
			}
			else
			{
				first_scene = {scene_id: scene_id, secs: secs, json_url: json_url};
			}
		}, false);
	});
}

function highliteControlTab(scene_id)
{
	$('#scene_controls li').removeClass('active');
	$('#scene_'+scene_id).addClass('active');
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
					$('#new_time_scene_modal #'+scene_time_id).val(player_time);
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

function bindCommentRatingButtons(url)
{
		$('ul.rating li.arrow').click(function(){
			container = $(this).parents('ul.rating');
			comment_id = $(container).attr('id').replace('comment_', '');
			$.ajax({
				url: url,
				type: "POST",
				data: {id : comment_id, sign: $(this).hasClass('max') ? 1 : 0},
				beforeSend: function( xhr ) {
					toggleAjaxLoader('_'+comment_id);
				},
				success: function( data ) {
					$(container).find('div').html(data['scene_comment_rating']);
					toggleAjaxLoader('_'+comment_id);
				}
			});
		});
}