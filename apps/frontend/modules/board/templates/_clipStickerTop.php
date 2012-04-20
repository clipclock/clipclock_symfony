
<div class="top">
	<div class="ph">
		<a href="<?php echo $user_link?>" target="_blank">
			<img width="30" height="30" alt="" src="<?php echo $user_image?>" />
		</a>
	</div>
	<p>
		<a href="<?php echo $user_link?>" target="_blank"><?php echo $user_nick?></a>
		<span class="time">Via <?php echo $provider_name?> <?php echo time_ago($created_at, 1)?></span>
	</p>
</div>
