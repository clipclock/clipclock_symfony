function getModalDialog(url) {

}

function repinClip()
{
    newRepinContainer();
    //newRepinModalShow();
}

function newRepinModalShow()
{
	//$('#new_time_scene_description_container_submit').click(function(){
		//if($('#new_time_scene_description').val().length > 3)
		{
			$('#new_repin_modal').toggle();
			//$('#shadow').toggle();

			//ytplayer = document.getElementById("scene_embed_video_player");
			//$('#new_time_scene_modal #scene_time_scene_time').val(ytplayer.getCurrentTime());
			//$('#new_time_scene_modal #scene_time_scene_text').val($('#new_time_scene_description').val());
		}
		return false;
	//});
}

function newRepinContainer()
{
	$().ready(function(){
		$('#new_repin').click(function(){
			//$('#scene_info').toggle();
			//$('#scene_add_comment').toggleClass('active');
			/*
            ytplayer = document.getElementById("scene_embed_video_player");
			if(ytplayer.getPlayerState() == 1)
			{
				ytplayer.pauseVideo();
			}
			else
			{
				ytplayer.playVideo();
			}
			*/
			newRepinModalShow();
			return false;
		});
	});
}