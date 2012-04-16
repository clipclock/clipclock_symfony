window.tooltipTimer = 0;
window.tooltipShowTimer = 0;

$(function(){

	var tooltipsCollection = {
		/* screen 1*/
		'1|#new_repin': 'Copy this clip to one of your own channels.',
		'2|#d_clip_container': "Click to copy the link for commenting with the clip somebody's full length video post on Facebook.",
		'3|#scene_controls li': 'Click the tab to jump to another clip of this video.',
		'4|#scene_controls li.active': 'It is the active clip you are watching.',
		'5|#scene_controls li#new_time_scene': 'Click here to create your new clip to some great moment of this video. For anyone you share the clip video will start from the moment you clipped.',
		'6|#submit_comment': 'Add your comment to the current active clip.',
		/* screen 2*/
		'7|.head-search .inside': "Enter here YouTube video URL you'd like to clip with great moments.",
		'8|.b-search': "Search the clips and videos available on the ClipClock.com",
		/* for stickers */
		'9|.sticker-tab': 'Click this tab to see another clip preview - screenshot and comments.',
		'10|.sticker-tab.active': "This is the current active clip preview - screenshot and comments.",
		'11|.clip_sticker .b-video-image': "It's the screenshot of the selected video moment.",
		'12|.management-sticker li': 'Check the people who made Reclips, Comments and Likes to this clip.',
		'13|.name-of-scence a': "It's the title of the video. The sticker area is all about this single video.",
		/* screen 3*/
		'14|.social .item2 a': 'Visit the person’s Facebook account.',
		'15|.board_sticker .inner h4 a': 'Title of the thematic channel where person saved some of his clips.',
		'16|#scroll-to-top': 'Fly back to the page top',
		'17|#cuselFrame-filter-categories': 'Select seeing all clips on the main page or only clips created by the people you follow.',
		'18|#filter-interests': 'Select your set of interests for the main page.',
		'19|.b-follow.following': 'People you follow.',
		'20|.b-follow.followers': 'People who follow you.'
	};

	var getCookie = function(name) {
		var cookie = " " + document.cookie;
		var search = " " + name + "=";
		var setStr = null;
		var offset = 0;
		var end = 0;
		if (cookie.length > 0) {
			offset = cookie.indexOf(search);
			if (offset != -1) {
				offset += search.length;
				end = cookie.indexOf(";", offset)
				if (end == -1) {
					end = cookie.length;
				}
				setStr = unescape(cookie.substring(offset, end));
			}
		}
		return(setStr);
	}

	var showTooltip = function(obj, key)
	{
		window.tooltipTimer = clearTimeout(window.tooltipTimer);
		window.tooltipTimer = 0;

		var tooltip = $('.b-tooltip').hide();

		if (!tooltip.length){
			$('body').append('<div class="b-tooltip radius4"><div class="wrap"><p></p><div class="ok radius3">Ok</div></div><div class="pointer"></div></div>');
			tooltip = $('.b-tooltip');
		}

		$(tooltip).find('p').html(tooltipsCollection[key]);
		$(tooltip).attr('data-key', 'tt' + key.split('|')[0]);

		$(tooltip).removeClass('top-right')
				.removeClass('bottom-left')
				.removeClass('bottom-right');

		$(tooltip).show(0, function(){

			// positions
			var ol = $(obj).offset().left;
			var ot = $(obj).offset().top;
			var x = ol - 20;
			var y = ot + 25;

			if (ol > $(document).width()/2 + $(tooltip).outerWidth() + 25){

				x = x - $(tooltip).width() + 25 + $(obj).width() / 2;

				if (ot > $(window).height() + $(document).scrollTop() - $(tooltip).outerHeight() - 50){
					$(tooltip).addClass('bottom-right');
					y = y - $(tooltip).outerHeight() - 25;
				} else {
					$(tooltip).addClass('top-right');
				}
			} else {
				if (ot > $(window).height() + $(document).scrollTop() - $(tooltip).outerHeight() - 50){
					$(tooltip).addClass('bottom-left');
					y = y - $(tooltip).outerHeight() - 25;
				}
			}

			$(tooltip).css({
				left: x,
				top: y
			});
		});
	}

	var hideTooltip = function(force)
	{
		if (force){
			$('.b-tooltip').hide();
		} else {
			if (window.tooltipTimer == 0)
				window.tooltipTimer = setTimeout(function(){
					$('.b-tooltip').hide();
				}, 500);
		}
	}

	// bindings
	$('.b-tooltip').live('mouseenter', function(){
		clearTimeout(window.tooltipTimer);
		window.tooltipTimer = 0;
	});

	$('.b-tooltip').live('mouseleave', function(){
		hideTooltip();
	});

	$('.b-tooltip .ok').live('click', function(){
		hideTooltip(true);
		setCookie($('.b-tooltip').attr('data-key'), "1", "Mon, 01-Jan-2037 00:00:00 GMT", "/");
	});

	// bindings for tooltip collection's elements
	for(key in tooltipsCollection){
		(function(){
			var _key = key;

			$(_key.split('|')[1]).live('mouseenter', function(){
				if (!window.tooltipShowTimer)
					window.tooltipShowTimer = setTimeout(function(){
						if (getCookie('tt' + _key.split('|')[0]) == null)
							showTooltip(this, _key);
					}.bind(this), 500);
			}).live('mouseleave', function(){
				clearTimeout(window.tooltipShowTimer);
				window.tooltipShowTimer = 0;
				hideTooltip();
			});
		})();
	}
});