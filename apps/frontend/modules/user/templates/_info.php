<div class="ph">
	<a href="<?php echo url_for('user', $user)?>"><img src="<?php echo $avatar_img?>" alt="" /></a>
</div>
<!-- /ph -->
<!-- social  -->
<ul class="social">
<?php foreach($ext_profiles as $ext_profile):?>
	<?php switch($ext_profile->getProvider()): case 1:?>
		<li class="item2"><a href="<?php echo $ext_profile->getExtLink()?>" target="_blank"></a></li>
		<?php break;?>
	<?php endswitch?>
<?php endforeach?>
</ul>