/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 15.02.12
 * Time: 18:18
 * To change this template use File | Settings | File Templates.
 */
current_scene_id = 0;
first_scene = null;
elems_scenes_ids = [];

function stickerChange(data, clip_id, scene_id)
{
	var data = JSON.parse(data);
	$('#image_'+clip_id).html(data.scene_image);
	$('#comments_list_'+clip_id).html(data.scene_comments_list);
	$('#comments_list_footer_'+clip_id).html(data.scene_footer);
	$('#clip_control_'+clip_id+' li').removeClass('active');
	$('#sticker_'+clip_id+'_'+scene_id).addClass('active');
	toggleAjaxLoader('_'+clip_id);
	$('#comments_list_'+clip_id+' .sticker_new_comment').removeClass('hidden');
	$('.clip_sticker').wookmark('update');
}

/* live override click event for sticker tabs */

var stickerChangeCache = {}; // will be removed then we will add namespaces

$('.sticker-tab a').live('click', function(){

	var el = this;

	if (checkCurrentSticker($(el).attr('data-reclip-id'), $(el).attr('data-scene-id'))) {

		if (stickerChangeCache[$(el).attr('data-url')] != undefined)
			stickerChange(stickerChangeCache[$(el).attr('data-url')], $(el).attr('data-reclip-id'), $(el).attr('data-scene-id'));
		else
			jQuery.ajax({
				url: $(el).attr('data-url'),
				type: 'GET',
				dataType: 'html',
				success:function(d){
					stickerChangeCache[$(el).attr('data-url')] = d;
					stickerChange(d, $(el).attr('data-reclip-id'), $(el).attr('data-scene-id'));
				}
			});
	};

	return false;
});

function boardCategoryChangeComplete(data)
{
	var data = JSON.parse(data);
	if(data.success)
	{
		closeWelcome(false);
	}
}

function boardCategoryChange()
{
	$('#board_category').change(function(){
		$(this).parents('form').submit();
	});
}

function checkCurrentSticker(clip_id, scene_id)
{
	toggleAjaxLoader('_'+clip_id);

	return true;
}

function toggleAjaxLoader(elem_id, pre_elem)
{
	if(!elem_id)
	{
		elem_id = '';
	}

	$((pre_elem ? pre_elem : '') + '.ajax_toogle'+elem_id).toggleClass('ajax_hider');
	$((pre_elem ? pre_elem : '') + '.ajax_toogle_container'+elem_id).toggleClass('ajax_loader');
}

function sceneChange(json_data, dont_history, url, json_url, secs, scene_id, modal)
{
	var data = JSON.parse(json_data);
	$('#comment_form').html(data.scene_comment_form);
	$('#comments').html(data.scene_comments_list);
	$('#fun_buttons').html(data.scene_social_buttons);
	$('#people_sticker').html(data.scene_people_sticker);
	$('#nav_path').html(data.nav_path);
	$('#nav_avatar').html(data.nav_avatar);

	if(modal)
	{
		$('#owner_text').html(data.owner_text);
		$('#owner_avatar').html(data.owner_avatar);
		$('#owner_button').html(data.owner_button);
		$('#channel').html(data.board);
		$('#people_modal').html(data.people_modal);
		/*$('#new_repin_modal .modal_form').html(data.repin_form);
		$('#new_time_scene_modal .modal_form').html(data.new_scene_form);*/
		bindFollow();
	}

	bindCommentRatingButtons(data.rating_url);
	toggleAjaxLoader();
	bindClipboardCopy(url);

	if(!dont_history)
	{
		history.pushState({json_url: json_url, secs: secs, scene_id: scene_id}, 'Title', url);
	}

	_kmq.push(['record', 'Viewed scene']);
}

function showSceneDescription(scene_id)
{
	if(!$('#scene_description_'+scene_id+':visible').length || $('#description div.scene_description:visible').length > 1)
	{
		$('#description div.scene_description:visible').hide().stop(true, true);
		$('#scene_description_'+scene_id).fadeIn();
	}
}

function bindSceneTextChangeHover()
{
	$('#scene_controls li').hover(function(){

		if(!elems_scenes_ids[$(this).attr('id')])
		{
			elems_scenes_ids[$(this).attr('id')] = $(this).attr('id').replace('scene_', '');
		}

		showSceneDescription(elems_scenes_ids[$(this).attr('id')]);
	}, function(e){
		if($(e.relatedTarget).attr('id') != 'scene_controls')
		{
			showSceneDescription(
					$('#scene_controls li.active').attr('id').replace('scene_', '')
			);
		}
	});

	$('#scene_controls').hover(function(){}, function(){
		active_id = $('#scene_controls li.active').attr('id').replace('scene_', '');
		showSceneDescription(active_id);
	});
}

function bindSceneChangeBack(json_url, secs, scene_id, current_url)
{
	$().ready(function(){
		bindSceneTextChangeHover();
		bindClipboardCopy(current_url);
		window.addEventListener('popstate', function(e){
			if(e.state && e.state.json_url)
			{
				json_url = e.state.json_url;
				secs = e.state.secs;
				scene_id = e.state.scene_id;
			}
			else if($('#clip_modal').length && e.state)
			{
				toggleModalScene();
				return true;
			}

			if(scene_id && secs && json_url)
			{
				$.ajax({
					url: json_url,
					beforeSend: function(){highliteControlTab(scene_id);seekTo(secs);toggleAjaxLoader();},
					dataType: 'text',
					success: function(data){
						sceneChange(data, true);
					}
				});
			}

			if(!first_scene)
			{
				first_scene = {scene_id: scene_id, secs: secs, json_url: json_url};
			}

			scene_id = null;
			secs = null;
			json_url = null;

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
	if(!$('#clip_modal:visible').length)
	{
		$('#shadow').toggle();
	}

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
			if($('#new_time_scene_description').val().length > 3 && $('#new_time_scene_description').val() != $('#new_time_scene_description').attr('defaulttext'))
			{
				if(getPlayer())
				{
					var player_time = getPlayer().getCurrentTime();
					$('#new_time_scene_modal #'+scene_time_id).val(player_time);
					var label_time = secondsToTime(player_time);
					$('#label_time').html(label_time.m+':'+label_time.s);
				}

				$('#new_time_scene_modal').toggle();
				$('#new_time_scene_modal').offset({top: $(window).scrollTop()+80});
				if(!$('#clip_modal:visible').length)
				{
					$('#shadow').toggle();
				}

				$('#new_time_scene_modal #scene_time_post_facebook').val($('#facebook_checkbox input').is(':checked'));
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
		if(!$('#clip_modal:visible').length)
		{
			newSceneTimeModalShow('scene_time_scene_time', 'scene_time_scene_text');
		}

		$('#new_time_scene').click(function(){
			new_time_scene_pause_player()
			return false;
		});
	});
}

function checkCommentForm(elem)
{
	if(!elem)
	{
		elem = 'comment_form';
	}
	return $('#'+elem+' form textarea').val() ? true : false;
}

function prependNewComments(data, list_id, comment_text_area_id, scroll_to_id)
{
	var data = JSON.parse(data);

	$('#'+list_id).prepend(data.scene_new_comment);
	$('#'+comment_text_area_id+' textarea').val('');

	var new_comment = $('#'+list_id+' div:first');

	if($(new_comment).is(":hidden"))
	{
		$(new_comment).css('background-color', '#ffff99');
		$(new_comment).slideDown("slow", function(){
			if(!scroll_to_id)
			{
				$(".clip_sticker").wookmark("update");
			}
		});
		$(new_comment).animate({
			'background-color': '#ffffff'
		}, 3000, function(){
			$(new_comment).attr('style', '');
		});
	}

	if(scroll_to_id)
	{
		$('html, body').animate({scrollTop:$('#'+scroll_to_id).offset().top - 5}, 600, 'easeOutQuart');
	}
}

function submitButtonSticker(root_elem)
{
	$('#'+root_elem+' textarea').keypress(function(event){
		if(event.which == 13 ) {
			event.preventDefault();
			$('#'+root_elem+' form').trigger('onsubmit');
		}
	});
}

function submitButton(submit_id, form_id)
{
	$().ready(function(){
		$('#'+submit_id).click(function(){
			$('#comment_form form').trigger('onsubmit');
			$('#comment_form').addClass('ajax_load');
			return false;
		});
	});
}

var scrollTopState = false;

function toggleModalScene(url)
{
	var overflowValue = $('.clip_modal_fixed:visible').length ? 'auto' : 'hidden';
	$('body').css({
		overflow: overflowValue
	});

	if (!$('.clip_modal_fixed:visible').length)
	{
		scrollTopState = $('#scroll-to-top').css('display');
		$('#scroll-to-top').hide();
	}
	else
	{
		if (scrollTopState == 'block'){
			$('#scroll-to-top').show();
			scrollTopState = false;
		}
	}

	$('.clip_modal_fixed #scene_embed_video_player').replaceWith('<span></span>');
	$('#shadow').toggle();
	$('.clip_modal_fixed').toggle();
	$('#clip_modal').offset({top: $(window).scrollTop()+30, left: 0});

	if(url && url != window.location.href)
	{
		history.pushState({}, 'Title', url);
		$('#clip_embed h2').html('&nbsp;');
		$('#description .inside').html('');
		$('#clip_controls').html('');
	}
}

function stickerClick(reclip_id, url, history_url, json_url, secs, scene_id) {

	$.ajax({
		url:url,
		beforeSend:function (xhr) {
			toggleModalScene();
			toggleAjaxLoader(null, '#clip_modal ');
			history.pushState({json_url:json_url, secs:secs, scene_id:scene_id}, 'Title', history_url);
			_kmq.push(['record', 'Viewed video']);
		},
		success:function (data) {

			$('#fun_buttons').html(data.scene_social_buttons);
			$('#clip_controls').html(data.scene_controls);
			$('#clip_embed').html(data.scene_embed);
			$('#description').html(data.scene_description);
			$('#comment_form').html(data.scene_comment_form);
			$('#comments').html(data.scene_comments_list);
			$('#owner_text').html(data.owner_text);
			$('#owner_avatar').html(data.owner_avatar);
			$('#owner_button').html(data.owner_button);
			$('#channel').html(data.board);
			$('#people_modal').html(data.people_modal);
			$('#new_repin_modal .modal_form').html(data.repin_form);
			$('#new_time_scene_modal .modal_form').html(data.new_scene_form);

			toggleAjaxLoader(null, '#clip_modal ');
			cuselActivate(6);
			bindCommentRatingButtons(data.rating_url);
			bindFollow();
			repinClip();
		}
	});

	return false;
}

/* live wrapper for stickerClick */

$('.clip_sticker a.sticker_image').live('click', function () {

	var clipSticker = $(this).parents('.clip_sticker');

	return stickerClick(
			$(clipSticker).attr('data-reclip-id'),
			$(clipSticker).attr('data-url'),
			$(clipSticker).attr('data-history-url'),
			$(clipSticker).attr('data-json-url'),
			$(clipSticker).attr('data-secs'),
			$(clipSticker).attr('data-scene-id')
	);

});

function bindClipboardCopy(url)
{
	var clip = null;
	ZeroClipboard.setMoviePath( '/js/ZeroClipboard.swf' );
	clip = new ZeroClipboard.Client();
	clip.setHandCursor( true );
	clip.addEventListener('mouseOver', function (client) {
		// update the text on mouse over
		clip.setText(url);
	});

	clip.glue( 'copy_link', 'd_clip_container' );
	$('#d_clip_container').hover(function(){$(this).find('a').toggleClass('hover');});
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