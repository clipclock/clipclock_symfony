function backend_quest_001()
{
	$().ready(function(){
		
	});
}

function __set_calendars(elem)
{
    $().ready(function(){
        $(elem).each(function(i) {
	      
            var d = new Date($(this).val());
            $(this).datepicker({
                minDate: "-2y",
                maxDate: "+2y",
                defaultDate: d
            });
            pickers.push($(this));
        });
    });
}

$(function() {
  if ($('#sf_admin_bar').size()) {
	
  var filter_show_hide = $('<a>') // create a DOM element
    .attr('href','#')
    .attr('id','filter-show-hide')
    .html('Показать фильтры ∇')
    .css('fontWeight', 'bold') // some styling
    .css('margin', '5px')
    .click(function(){
      $('#sf_admin_bar .sf_admin_filter tbody').toggle();
      if( $("#filter-show-hide").html() == 'Убрать фильтры Δ' ) // change the link text
        $("#filter-show-hide").html('Показать фильтры ∇');
      else
        $("#filter-show-hide").html("Убрать фильтры Δ");
      return false;
    });

    //add filter header
    jQuery('#sf_admin_bar .sf_admin_filter table tbody').before("<thead><tr><th colspan='2'></th></tr></thead>");
	$('#sf_admin_bar .sf_admin_filter thead th').append(filter_show_hide);
  }
});