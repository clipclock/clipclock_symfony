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
// end очистка поллей вода текста


	$('.welcome .close').click (function() {
		$('.welcome, .welcome .inner').slideUp(700);
	});

	$().UItoTop({ easingType: 'easeOutQuart', scrollSpeed: 200, containerID: 'scroll-to-top' });
// end плавное закрытие блока WELCOME
});


function layoutAndScroll(path, elem, width)
{
	if(!elem)
	{
		elem = 'clip_sticker';
	}

	if(!width)
	{
		width = 235;
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
			pixelsFromNavToBottom: 1500
			// selector for all items you'll retrieve
		},function(arrayOfNewElems){
			$('.'+elem).wookmark({
				container: $('#container'),
				offset: 5,
				itemWidth: width,
				autoResize: true
			});
		} );
		var handler = $('.'+elem).wookmark({
			container: $('#container'),
			offset: 5,
			itemWidth: width,
			autoResize: true
		});
	});
}