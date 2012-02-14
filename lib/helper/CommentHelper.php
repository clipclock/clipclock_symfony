<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 14.02.12
 * Time: 13:58
 * To change this template use File | Settings | File Templates.
 */
function calculateCommentListLength($unique_comments_count)
{
	$return_count = 1;
	if($unique_comments_count >= 3 && $unique_comments_count < 7)
	{
		$return_count = 2;
	}
	elseif($unique_comments_count >= 7 && $unique_comments_count <= 20)
	{
		$return_count = 3;
	}
	elseif($unique_comments_count > 20 && $unique_comments_count <= 50)
	{
		$return_count = 4;
	}
	elseif($unique_comments_count > 50)
	{
		$return_count = 5;
	}

	return $return_count;
}