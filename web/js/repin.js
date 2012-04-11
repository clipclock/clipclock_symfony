function repinClip()
{
    newRepinContainer();
}

function newRepinModalShow()
{
	    $('#new_repin_modal').toggle();
		return false;
}

function newRepinContainer()
{
	$().ready(function(){

        $('#new_repin_modal .close,  #new_repin_modal .default-un-follow-btn').click(function(){
            $('#new_repin_modal').toggle();

            var player = getPlayer();
            if(player.getPlayerState() == 1)
            {
                player.pauseVideo();
            }
            else
            {
                player.playVideo();
            }
        });

		$('#new_repin').click(function(){
			var player = getPlayer();
            if(player.getPlayerState() == 1)
            {
                player.pauseVideo();
            }
            else
            {
                player.playVideo();
            }
            newRepinModalShow();
            return false;
        });

        $('#un_repin').click(function(){
            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data, textStatus, jqXHR) {
					_kmq.push(['record', 'Reclip exists scene']);
                    if (data.result == 'success')
                        document.location.href = data.location;
                }
            });

            return false;
        });
	});
}
