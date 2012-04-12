$(function(){

	$('.clip_sticker').live('mouseenter', function(){
		(function(o){

			if ($(o).attr('data-duration') != '0'){

				var el = $(o).find('.b-band-scroll .band-wrap');
				$(el).show();

				if (!$(o).hasClass('maker-set')){

					var duration = parseInt($(o).attr('data-duration'));
					var tab_time = parseInt($(o).find('.sticker-tab.active a').attr('data-time'));

					if (tab_time > duration)
						tab_time = duration;

					var value = Math.round(100 * tab_time / duration);
					if (value >= 100)
						value = 95;

					$(el).find('.marker').css({ left: value + '%' });
					$(el).find('.band').css({ width: value + '%' });

					$(o).addClass('marker-set');

				}
			}
		})(this);
	});

	$('.clip_sticker').live('mouseleave', function(){
		(function(o){
			$(o).find('.b-band-scroll .band-wrap').hide();
		})(this);
	});

});