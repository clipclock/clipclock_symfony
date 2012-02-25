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

            ytplayer = document.getElementById("scene_embed_video_player");
            if(ytplayer.getPlayerState() == 1)
            {
                ytplayer.pauseVideo();
            }
            else
            {
                ytplayer.playVideo();
            }
        });

		$('#new_repin').click(function(){
            ytplayer = document.getElementById("scene_embed_video_player");
            if(ytplayer.getPlayerState() == 1)
            {
                ytplayer.pauseVideo();
            }
            else
            {
                ytplayer.playVideo();
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
                    console.log(data);
                    if (data.result == 'success')
                        document.location.href = data.location;
                }
            });

            return false;
        });
	});
}
