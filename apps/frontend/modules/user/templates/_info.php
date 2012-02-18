<?php echo $avatar_img?><br />
<?php foreach($ext_profiles as $ext_profile):?>
	<?php switch($ext_profile->getProvider()): case 1:?>
			<a href="<?php echo $ext_profile->getExtLink()?>" target="_blank">Facebook</a>
			<?php break;?>
	<?php endswitch?>
<?php endforeach?>