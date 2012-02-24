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
       $('.welcome, .welcome .inner').slideUp(1500);
    });
// end плавное закрытие блока WELCOME

});