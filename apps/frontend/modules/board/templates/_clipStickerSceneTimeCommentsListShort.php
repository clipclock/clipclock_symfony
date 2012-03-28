<ul class="tabs-items">
	<li class="active">
		<div class="b-comment description">
			<div class="inside">
				<div class="ph"><a href="<?php echo url_for('user', array('nick' => $scene_info['nick']))?>"><img src="<?php echo ImagePreview::c14n($scene_info['user_id'], 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
				<p><a href="<?php echo url_for('user', array('nick' => $scene_info['nick']))?>"><?php echo $scene_info['first_name'] . ' '.$scene_info['last_name'];?></a><?php echo truncate_text($scene_info['text'], 140, '…', true);?></p>
			</div>
		</div>
	<div class="list">
	<?php foreach($comments as $key => $comment):?>
		<?php include_partial('board/clipStickerSceneTimeComment', array('comment' => $comment)) ?>
	<?php endforeach;?>
	</div>
	<?php if($user->getId()):?>
		<div class="b-comment sticker_new_comment hidden">
			<div class="inside">
				<div class="ph"><a href="<?php echo url_for('user', $sf_user)?>"><img src="<?php echo ImagePreview::c14n($sf_user->getId(), 'small', 'avatar');?>" alt="" width="30" height="30" /></a></div>
				<?php echo jq_form_remote_tag(array(
					'url' => '@scene_post_comment?sticker=true',
					'update' => array('success_callback' => 'prependNewComments(data, "comments_list_'.$reclip_id.' .list", "comments_list_'.$reclip_id.'", null);', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
					'condition' => 'checkCommentForm("comments_list_'.$reclip_id.'")',
				), array('id' => 'new_scene_comment'))?>
					<div class="brd">
						<?php echo $form['text']?><?php echo $form->renderHiddenFields()?>
					</div>
				</form>
				<script type="text/javascript">
					submitButtonSticker('comments_list_<?php echo $reclip_id ?>', '.hidden_button');
				</script>
			</div>
		</div>
	<?php endif;?>
	</li>
</ul>