$(function(){

	var tooltipTimer;

	var tooltipsCollection = {
		//'a#new_repin': 'Copy this clip to one of your own channels.',
		'.sticker-tab': 'Select seeing all clips on the main page or only clips created by the people you follow.'
	};

	for(key in tooltipsCollection){
		$(key).attr('data-tooltip', tooltipsCollection[key]).addClass('tooltip');
		//console.log(key, $(key).attr('data-tooltip'), $(key).hasClass('tooltip'));
	}

	/* closing */
	$('.b-tooltip .ok').live('click', function(){
		clearTimeout(tooltipTimer);
		$(this).parents('.b-tooltip').hide();
		/* store that it was close */
	});

	/* showing */
	$('.tooltip').live('mouseenter', function(e){

		console.log(e);

		var el = this;

		clearTimeout(tooltipTimer);
		$('.b-tooltip').hide();

		var tooltip = $('.b-tooltip');

		if (!tooltip.length){
			$('body').append('<div class="b-tooltip radius4"><div class="wrap"><p></p><div class="ok radius3">Ok</div></div><div class="pointer"></div></div>');
			tooltip = $('.b-tooltip');
		}

		$(tooltip).find('p').html($(el).attr('data-tooltip'));

		$(tooltip).show(0, function(){
			$(tooltip).css({
				left: $(el).offset().left,
				//top: $(el).offset().top - $(tooltip).height() - $(el).height() - 10
				top: $(el).offset().top + 40
			});
		});

	});

	$('.b-tooltip').live('mouseenter', function(){
		clearTimeout(tooltipTimer);
	});

	$('.tooltip, .b-tooltip').live('mouseleave', function(){
		tooltipTimer = setTimeout(function(){
			$('.b-tooltip').hide();
		}, 500);
	});
});