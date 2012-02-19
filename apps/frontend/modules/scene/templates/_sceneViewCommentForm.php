<?php if($sf_user->getId()):?>
<div class="inside">
	<div class="ph">
		<a href="#"><img src="images/avatars/user-title-pic-2.jpg" alt="" width="50" height="50" /></a>
	</div>
	<?php echo jq_form_remote_tag(array(
		'url' => 'scene_post_comment',
		'update' => array('success_callback' => 'prependNewComments(data, "comments");', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
		'condition' => 'checkCommentForm("textarea#text")',
	))?>
		<?php echo $form['text']?><?php echo $form->renderHiddenFields()?>
		<div class="b-btn">
			<input id="submit_comment" class="default-un-follow-btn" name="" type="button" value="Comment" />
		</div>
	</form>
</div>
<script type="text/javascript">
	submitButton('submit_comment', 'comment_form form');
</script>
<?php endif?>