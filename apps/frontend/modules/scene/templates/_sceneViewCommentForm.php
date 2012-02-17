<?php echo jq_form_remote_tag(array(
	'url' => 'scene_post_comment',
	'update' => array('success_callback' => 'prependNewComments(data, "comments");', 'failure' => "alert('HTTP Error ' + XMLHttpRequest.status + '!')"),
	'condition' => 'checkCommentForm("textarea#text")',
))?>
	<?php echo $form?><br />
	<a href="#" id="submit_comment">Submit comment</a>
</form>
<script type="text/javascript">
	submitButton('submit_comment', 'comment_form form');
</script>