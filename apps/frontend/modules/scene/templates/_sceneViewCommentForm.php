<?php if($current_user->getId()):?>
<div class="inside">
	<div class="ph">
		<a href="<?php echo url_for('user', $current_user)?>"><img src="<?php echo ImagePreview::c14n($current_user->getId(), 'medium', 'avatar');?>" alt="<?php echo $current_user->getFullName()?>" title="<?php echo $current_user->getFullName()?>" width="50" height="50" /></a>
	</div>
	<?php echo jq_form_remote_tag(array(
		'url' => 'scene_post_comment',
		'update' => array('success_callback' => 'prependNewComments(data, "comments", "comment_form_text", "scene_controls");', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
		'condition' => 'checkCommentForm()',
	))?>
		<div id="comment_form_text" class="brd">
			<?php echo $form['text']?><?php echo $form->renderHiddenFields()?>
		</div>
		<div class="b-btn">
			<input id="submit_comment" class="default-un-follow-btn" name="" type="button" value="Comment" />
		</div>
	</form>
</div>
<script type="text/javascript">
	submitButton('submit_comment', 'comment_form form');
</script>
<?php endif?>