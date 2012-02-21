function getModalDialog(url) {

}

function repinClip()
{
    newRepinContainer();
    //newRepinModalShow();
}

function newRepinModalShow()
{
		{
			$('#new_repin_modal').toggle();
		}
		return false;
}

function newRepinContainer()
{
	$().ready(function(){
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
            var user_id = $(this).attr('user_id');
            var scene_id = $(this).attr('scene_id');

            $.ajax({
                url: url,
                type: "GET",
                data: { user_id : user_id, scene_id : scene_id }
            });

            return false;
        });
	});
}