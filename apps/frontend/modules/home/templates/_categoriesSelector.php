<div class="pop-window" id="interests" style="display: none">
<div class="close"></div>
<!-- scence-autor  -->
<div class="scence-autor">
	<div class="user-pic">
		<?php if($current_user->getId()):?>
		<a href="<?php echo url_for('user', $current_user)?>"><img src="<?php echo ImagePreview::c14n($current_user->getId(), 'medium', 'avatar');?>" alt="" width="50" height="50" /></a>
		<?php endif;?>
	</div>
	<div class="name">
		<a href="">My Interests</a>
		<div class="date">Select your interests for the main page clips.</div>
	</div>
</div>
<!-- /scence-autor -->
<!-- b-content  -->
<div class="b-content">
<!-- b-interests-list  -->
<div class="b-interests-list">
<form class="frm" action="" method="get">
<ul>
<li>
	<?php foreach($all_categories as $key => $category):?>
	<div id="category_<?php echo $category->getId()?>" class="rowElem<?php if(!count($categories) || $categories[$category->getId()]):?> active<?php endif?>">
		<div class="top"></div>
		<input type="checkbox" />
		<label><?php echo $category->getName()?></label>
	</div>
	<?php if($key == 9 || $key == 19 || $key == 29):?>
</li>
<li>
	<?php endif;?>
	<?php endforeach?>
</li>
</ul>
</form>
<div class="b-btn">
	<a href="#" id="reset" class="default-un-follow-btn">Reset</a>
	<a href="#" id="slct-all" class="default-un-follow-btn">Select All</a>
	<input type="submit" class="default-follow-btn" value="Save" />
</div>
</div>
<!-- /b-interests-list -->
</div>
<!-- /b-content -->
</div>
	<script type="text/javascript">
		categoryMultiSelect();
	</script>