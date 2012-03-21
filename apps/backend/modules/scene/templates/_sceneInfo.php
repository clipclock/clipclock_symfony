<?php echo $Scene->getSceneTime();?><br />
<?php echo image_tag(ImagePreview::c14n($Scene->getSceneTime()->getReclip()->getClipId().$Scene->getSceneTime()->getSceneTime()))?>