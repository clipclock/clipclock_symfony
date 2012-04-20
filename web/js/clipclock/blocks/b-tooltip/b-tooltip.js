/* smart tooltips */

$(function(){

	// helpers

	var setTooltipCookie = function(value){
		setCookie('tooltips', value, "Mon, 01-Jan-2037 00:00:00 GMT", "/");
		setCookie('tooltips-changed', '1', "Mon, 01-Jan-2037 00:00:00 GMT", "/");
	}

	var getCookie = function(key){

		var cookie = '' + document.cookie;
		var findme = '' + key + '=';

		if (cookie.length > 0){

			var offset = cookie.indexOf(findme);

			if (offset != -1){
				offset += findme.length;

				var end = cookie.indexOf(';', offset);
				if (end == -1)
					end = cookie.length;

				return unescape(cookie.substring(offset, end));
			}
		}

		return null;
	}

	var ToolTipper = function(){

		var context = this,
				showTimer = 0,
				hideTimer = 0;

		var tooltips = [];
		var hiddenTooltips = [];

		// build b-tooltip
		var tooltip = $('.b-tooltip').hide();
		if (!$(tooltip).length){
			$('body').append('<div class="b-tooltip radius4" style="display:none;"><div class="wrap"><p></p><div class="ok radius3">Ok</div><div class="hide-all"><a href="">Hide all hints</a></div></div><div class="pointer"></div></div>');
			tooltip = $('.b-tooltip');
		}

		// get hidden tooltips from cookies
		var cookieTooltips = getCookie('tooltips');
		if (cookieTooltips != null)
			hiddenTooltips = cookieTooltips.split(',');

		var showTooltip = function(obj, index)
		{
			clearTimeout(hideTimer); hideTimer = 0;

			$(tooltip).removeClass('top-right')
					.removeClass('bottom-left')
					.removeClass('bottom-right');

			$(tooltip).find('p').html(tooltips[index].msg);
			$(tooltip).attr('data-tooltip-index', index);

			$(tooltip).show(0, function(){

				// calculate positions

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

				// custom align for image ((
				if (tooltips[index].sel == '.clip_sticker .b-video-image' && !$(tooltip).hasClass('bottom-right') && !$(tooltip).hasClass('bottom-left')){
					y = y + 50;
					if (!$(tooltip).hasClass('top-right')){
						x = x + 60;
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
			if (!force){

				if (!hideTimer){
					hideTimer = setTimeout(function(){
						hideTooltip(true);
					}, 150);
				}

			} else {
				$(tooltip).hide();
			}
		}

		var bindEvents = function()
		{
			// more performance
			if (hiddenTooltips.length == tooltips.length)
				return true;

			$(tooltip).live('mouseenter', function(){
				clearTimeout(hideTimer); hideTimer = 0;
			}).live('mouseleave', function(){
						hideTooltip();
					});

			$(tooltip).find('.ok').click(function(){

				var index = $(tooltip).attr('data-tooltip-index');
				$(tooltips[index].sel).die('mouseenter').die('mouseleave');

				hiddenTooltips.push(index);
				setTooltipCookie(hiddenTooltips.join(','));

				hideTooltip(true);

			});

			$(tooltip).find('.hide-all a').click(function(){

				hiddenTooltips = [];
				for(key in tooltips){
					hiddenTooltips.push(key);
					$(tooltips[key].sel).die('mouseenter').die('mouseleave');
				}

				setTooltipCookie(hiddenTooltips.join(','));
				hideTooltip(true);

				return false;
			});

			var hiddenTooltipsMap = {};
			for (key in hiddenTooltips)
				hiddenTooltipsMap[hiddenTooltips[key]] = true;

			for (key in tooltips){
				// don't bind hidden tooltips
				if (!hiddenTooltipsMap[key]){
					(function(){

						var index = key;

						$(tooltips[key].sel).live('mouseenter', function(){
							if (!showTimer){
								showTimer = setTimeout(function(){
									showTooltip(this, index);
								}.bind(this), 250);
							}
						}).live('mouseleave', function(){
									clearTimeout(showTimer); showTimer = 0;
									hideTooltip();
								});

					})();
				}
			}
		}

		return {
			// sel = selector
			addTooltip: function(sel, msg){
				tooltips.push({
					sel: sel,
					msg: msg
				});
			},
			init: function(){
				bindEvents();
			}
		};
	};

	var tooltipper = new ToolTipper();

	// screen 1
	tooltipper.addTooltip('#new_repin', "Copy the clip to one of your channels.");
	tooltipper.addTooltip('#d_clip_container', "Copy link to the clip. Use it for commenting somebody's full length video post on Facebook.");
	tooltipper.addTooltip('#scene_controls li:not(.active):not(#new_time_scene)', 'Click the tab to watch the video starting with the clipped moment.');
	tooltipper.addTooltip('#scene_controls li.active', 'It is the active clip you are watching.');
	tooltipper.addTooltip('#scene_controls li#new_time_scene', 'Click here to create your clip for some great moment of this video. For anyone you share the clip video will start from the moment you clipped.');
	tooltipper.addTooltip('#submit_comment', 'Add your comment to the selected clip.');

	// screen 2
	tooltipper.addTooltip('.head-search .inside', "Enter YouTube video link/URL you'd like to clip.");
	tooltipper.addTooltip('.b-search', "Search the clips and videos available on the ClipClock.com");
	tooltipper.addTooltip('.b-search', "Search the clips and videos available on the ClipClock.com");
	// stickers
	tooltipper.addTooltip('.sticker-tab:not(.active)', 'Click to see next clip preview.');
	tooltipper.addTooltip('.sticker-tab.active', "Clip starts at the pointed time of video.");
	tooltipper.addTooltip('.clip_sticker .b-video-image', "It's the screenshot of the selected video moment.");
	tooltipper.addTooltip('.management-sticker li', "Check the people who made Reclips, Comments and Likes to this clip.");
	tooltipper.addTooltip('.name-of-scence a', "It's the video title. The sticker area is all about this single video.");

	// screen 3
	tooltipper.addTooltip('.social .item2 a', "Visit the person’s Facebook account.");
	tooltipper.addTooltip('.board_sticker .inner h4 a', "Title of the thematic channel where person saved some of his clips.");
	tooltipper.addTooltip('#scroll-to-top', "Fly back to the page top");
	tooltipper.addTooltip('#cuselFrame-filter-categories', "Select all clips for the main page or only clips created by the people you follow.");
	tooltipper.addTooltip('#filter-interests', "Select your set of interests for the main page.");
	tooltipper.addTooltip('.b-follow.following', "People you follow.");
	tooltipper.addTooltip('.b-follow.followers', "People who follow you.");
	tooltipper.addTooltip('.clip_sticker .b-btn a', "Highlight the best moment of this video and share it with friend who posted the video.");

	tooltipper.init();
});