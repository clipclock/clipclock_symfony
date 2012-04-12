function kissmetricsLoad(key){


	$().ready(function(){
		var _kmq = _kmq || [];
		(function(w, d) {
			function _kms(u){
				setTimeout(function(){
					var s = d.createElement('script');
					var f = d.getElementsByTagName('script')[0];
					s.type = 'text/javascript'; s.async = true;
					s.src = u; f.parentNode.insertBefore(s, f);
				}, 1);
			}
			function kmg(){
				_kms('//i.kissmetrics.com/i.js');
				_kms('//doug1izaerwt3.cloudfront.net/'+key+'.1.js');}
			if (w.addEventListener) { w.addEventListener("load", kmg, false); }
			else if (w.attachEvent) { w.attachEvent("onload",kmg); }
		}(window, document))
	});
}

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
		setCookie("welcome-close", "true", "Mon, 01-Jan-2091 00:00:00 GMT", "/");
	}

	$('.welcome, .welcome .inner').slideUp(700);
}

/* live override for stickerControlScrollers */

$(function(){

	$('.clip_sticker .arrow').live('click', function(){

		var siblings = $(this).siblings('.sticker-tab');

		if($(this).hasClass('next')){
			if($(this).offset().top != $(siblings).filter(':visible').last().offset().top)
				$(siblings).filter(':visible').first().hide();
		} else {
			$(siblings).filter(':not(:visible)').last().show();
		}
	});
});

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
				$(this).addClass('typing');
				$(this).val('');
			}
		}
	});

	$('.brd input, .head-search .inside .b-input input, .b-filter form .search-col .b-search .b-input input').bind('blur', function(){
		var title = $(this).attr('title');
		if (title != '') {
			if ($(this).val() == '') {
				$(this).removeClass('typing');
				$(this).val(title);
			}
		}
	});

	$('textarea').focus(function(){
		if($(this).attr('defaultText') == $(this).html())
		{
			$(this).addClass('typing');
			$(this).html('');
		}
	});
	$('textarea').blur(function(){
		if(!$(this).val().length)
		{
			$(this).html($(this).attr('defaultText'));
			$(this).removeClass('typing');
		}
	});

	$('.welcome .close_link, .welcome .close').click(function(){
		closeWelcome(true);
		return false;
	});

	$('.welcome .close').click (function() {
		closeWelcome(true);
	});

	$().UItoTop({ easingType: 'easeOutQuart', scrollSpeed: 200, containerID: 'scroll-to-top' });

	if($('#viewport').length > 0)
	{
		$('html, body').animate({scrollTop:$('div#viewport').offset().top - 3}, 500, 'easeOutQuart');
	}

	$('.b-interests-list form ul li .rowElem').click( function(){
		$(this).toggleClass('active');
	});

	$('.b-interests-list form ul li .rowElem label').click(function(){
		$(this).parents('.rowElem').toggleClass('active');
	});

	$('.b-interests-list .b-btn #reset').click( function(){
		$('.b-interests-list form ul li .rowElem').removeClass('active');
		$('.b-interests-list form ul li .rowElem .jqTransformCheckbox').removeClass('jqTransformChecked');
		return false;
	});
// end выделение всех списков интересов


	$('.b-interests-list .b-btn #slct-all').click( function(){
		$('.b-interests-list form ul li .rowElem').addClass('active');
		$('.b-interests-list form ul li .rowElem .jqTransformCheckbox').addClass('jqTransformChecked');
		return false;
	});
});

function cuselActivate(visRows, elems)
{
	if(!elems)
	{
		elems = ".line-form select";
	}
	$().ready(function(){
		$(elems).change(function(){
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
		width = 223;
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

function categoryMultiSelectorModalToggle()
{
	$('#interests').toggle();
	if($('#interests:visible').length)
	{
		$('#interests').offset({top: $(window).scrollTop()+40});
	}
	else
	{
		window.new_user = false;
	}
	$('#shadow_interests').toggle();
}

function categoryMultiSelect()
{
	$(function(){
		$('#interests .close').click(function(){
			categoryMultiSelectorModalToggle();
		});

		$('#shadow_interests').click(function(){
			categoryMultiSelectorModalToggle();
		});

		$('#categories_selected .line-form .cusel').click(function(){
			categoryMultiSelectorModalToggle();
		});

		$('#interests .frm').jqTransform({imgPath: 'images/'});
		$('.b-interests-list form ul li .active').each( function(){
			$(this).find('.jqTransformCheckbox').toggleClass('jqTransformChecked');
		});

		$('#interests form').submit(function(){
			var choices = [];
			$('#interests .frm .active').each(function(){
				choices.push($(this).attr('id').replace('category_', ''));
			});

			$('#home_filter_categories').val(choices.length >= $('#interests .frm .rowElem').length ? 'all' : choices.join(','));
			$('#filter_form').trigger('submit');
			return false;
		});
		$('#interests :submit').click(function(){$('#interests form').trigger('submit');});
	})
}