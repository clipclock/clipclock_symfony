
function setCookie (name, value, expires, path, domain, secure) {
	document.cookie = name + "=" + escape(value) +
			((expires) ? "; expires=" + expires : "") +
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			((secure) ? "; secure" : "");
}

function closeWelcome(cookie)
{
	if(cookie)
	{
		setCookie("welcome_close", "true", "Mon, 01-Jan-2091 00:00:00 GMT", "/");
	}

	$('.welcome, .welcome .inner').slideUp(700);
}

function stickerControlScrollers(elem)
{
	$().ready(function(){
		$('#'+elem+' .arrow').click(function(){
			var siblings = $(this).siblings('.sticker-tab');
			if($(this).hasClass('next'))
			{
				if($(this).offset().top != $(siblings).filter(':visible').last().offset().top)
				{
					$(siblings).filter(':visible').first().hide();
				}
			}
			else
			{
				$(siblings).filter(':not(:visible)').last().show();
			}
		});
	});
}

$(document).ready(function(){

	$('.brd input, .head-search .inside .b-input input, .b-filter form .search-col .b-search .b-input input').bind('focus', function(){
		var title = $(this).attr('title');
		if (title != '') {
			if ($(this).val() == title) {
				$(this).val('');
			}
		}
	});

	$('.brd input, .head-search .inside .b-input input, .b-filter form .search-col .b-search .b-input input').bind('blur', function(){
		var title = $(this).attr('title');
		if (title != '') {
			if ($(this).val() == '') {
				$(this).val(title);
			}
		}
	});

	$('textarea').focus(function(){
		if($(this).attr('defaultText') == $(this).html())
		{
			$(this).html('');
		}
	});
	$('textarea').blur(function(){
		if(!$(this).val().length)
		{
			$(this).html($(this).attr('defaultText'));
		}
	});

	$('.welcome .close').click (function() {
		closeWelcome(true);
	});

	$().UItoTop({ easingType: 'easeOutQuart', scrollSpeed: 200, containerID: 'scroll-to-top' });

	if($('#viewport').length > 0)
	{
		$('html, body').animate({scrollTop:$('div#viewport').offset().top - 3}, 500, 'easeOutQuart');
	}


});

function cuselActivate(visRows, elems)
{
	if(!elems)
	{
		elems = ".line-form select";
	}
	$().ready(function(){
		$(elems).change(function(){
			console.log($(this));
			$(this).parents('form').submit();
		});
		jQuery(".cusel").each(
				function(){
					var w = parseInt(jQuery(this).width()),
							scrollPanel = jQuery(this).find(".cusel-scroll-pane");
					if(w>=scrollPanel.width())
					{
						jQuery(this).find(".jScrollPaneContainer").width(w);
						scrollPanel.width(w);
					}
				});

		var params = {
			changedEl: elems,
			visRows: visRows,
			scrollArrows: true
		}
		cuSel(params);
	});
}

function layoutAndScroll(path, elem, width)
{
	if(!elem)
	{
		elem = 'clip_sticker';
	}

	if(!width)
	{
		width = 222;
	}
	$(document).ready(function(){
		$('#container').infinitescroll({

			navSelector  : "div.pager_navigation",
			// selector for the paged navigation (it will be hidden)
			nextSelector : "div.pager_navigation a:first",
			// selector for the NEXT link (to page 2)
			itemSelector : "li",
			dataType: 'json',
			path: path,
			loading:
			{
				finished: undefined,
				finishedMsg: "<em>No more clips</em>",
				img: '/images/ajax-loader-horizontal.gif',
				msg: null,
				msgText: "<em>Fetching new clips...</em>",
				selector: null,
				speed: 'fast',
				start: undefined
			},
			pixelsFromNavToBottom: 4500
			// selector for all items you'll retrieve
		},function(arrayOfNewElems){
			$('.'+elem).wookmark({
				container: $('#container'),
				offset: 12,
				itemWidth: width,
				autoResize: true
			});
		} );
		var handler = $('.'+elem).wookmark({
			container: $('#container'),
			offset: 12,
			itemWidth: width,
			autoResize: true
		});
	});
}