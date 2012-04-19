<!--1--><?php //ФБ видео не от внутрисистемных друзей и неразмеченное
if($sticker_type == 'new'):?>
	<?php include_component('board', 'clipStickerFromFb', array('current_user' => $current_user, 'reclip_id' => $reclip_id))?>
<?php //Не ФБ видео не от внутрисистемных друзей
elseif($sticker_type):?>
	<?php include_component('board', 'clipSticker', array('current_user' => $current_user, 'reclip_id' => $reclip_id))?>
<?php endif;?>