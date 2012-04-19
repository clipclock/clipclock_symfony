<li class="clip_sticker">
	<div class="inner">
		<div class="top">
			<div class="ph">
				<a href="http://facebook.com/<?php echo $reclip->getClip()->getClipSocialInfo()->getExtUser()->getExtId()?>" target="_blank">
					<img width="30" height="30" alt="" src="http://graph.facebook.com/<?php echo $reclip->getClip()->getClipSocialInfo()->getExtUser()->getExtId()?>/picture?type=small" />
				</a>
			</div>
			<p>
				<a href="http://facebook.com/<?php echo $reclip->getClip()->getClipSocialInfo()->getExtUser()->getExtId()?>" target="_blank"><?php echo $reclip->getClip()->getClipSocialInfo()->getExtUser()->getNick()?></a>
				<?php echo $reclip->getClip()->getClipSocialInfo()->getCreatedAt()?>
			</p>
		</div>
		<p class="name-of-scence">
			<?php echo $reclip->getClip()->getClipSocialInfo()->getDescription()?>
		</p>
		<div class="b-video">
			<div class="b-video-image" id="image_1404">
				<a href="<?php echo url_for('preview_new_clip_with_clip_id', array('clip_id' => $reclip->getClipId()))?>">
					<img width="192" height="144" alt="" src="http://viddii.dev/uploads/scenes/192/6b/f4/74/43/d0/37/ee/a5/f2/c9/a5/25/c0/c4/9c/e1/6bf47443d037eea5f2c9a525c0c49ce1.jpg" />
					<div class="arrow"></div>
				</a>
			</div>
		</div>
		<div class="msg">
			<div class="line1px"></div>
			<div class="pointer"></div>
			<div class="box">
				<p>What is the best moment of this video?</p>
			</div>
		</div>
		<div class="b-btn">
			<a href="<?php echo url_for('preview_new_clip_with_clip_id', array('clip_id' => $reclip->getClipId()))?>">Find and Share</a>
		</div>
	</div>
</li>