<!--1--><?php //ФБ видео не от внутрисистемных друзей и неразмеченное
if($fb_user_id && !$friended_video):?>
	<?php include_component('board', 'clipStickerFromFb', array('current_user' => $current_user))?>
<?php //Не ФБ видео не от внутрисистемных друзей
elseif($reclip_id && !$friended_video):?>
	<?php include_component('board', 'clipSticker', array('current_user' => $current_user, 'reclip_id' => $reclip_id))?>
<?php endif;?>