<?php if($category_form):?>
<div class="welcome" style="margin-bottom: 10px;">
	<div class="close"></div>
	<div class="inner">
		<div class="b-filter">
		<?php echo jq_form_remote_tag(array(
			'url' => url_for('board_vote', array('id' => $board_id)),
			'complete' => 'boardCategoryChangeComplete(XMLHttpRequest.responseText);'
		))?>
			<?php echo $category_form->renderHiddenFields()?>
			<div class="col">
				<label>Category</label>
				<div class="line-form special-line-form">
					<?php echo $category_form['category_id']->render(array('class' => 'size289', 'id' => 'board_category'))?>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
	<script type="text/javascript">
		cuselActivate(10, '.special-line-form select');
		boardCategoryChange();
	</script>
<?php endif;?>