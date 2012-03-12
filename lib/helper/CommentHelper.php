<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 14.02.12
 * Time: 13:58
 * To change this template use File | Settings | File Templates.
 */

function getCommentRatingSign($rating)
{
	$sign = '';
	if($rating > 0)
	{
		$sign = '+';
	}
	elseif($rating < 0)
	{
		$sign = '-';
	}

	return $sign;
}

function getCommentRatingClass($rating)
{
	$sign = getCommentRatingSign($rating);
	$class_name = '';
	switch($sign)
	{
		case '+':
			$class_name = 'pls';
			break;
		case '-':
			$class_name = 'mns';
			break;
	}

	return $class_name;
}

function calculateCommentListLength($unique_comments_count)
{
	$return_count = 1;
	if($unique_comments_count >= 2 && $unique_comments_count < 7)
	{
		$return_count = 3;
	}
	elseif($unique_comments_count >= 7 && $unique_comments_count <= 20)
	{
		$return_count = 4;
	}
	elseif($unique_comments_count > 20 && $unique_comments_count <= 50)
	{
		$return_count = 5;
	}
	elseif($unique_comments_count > 50)
	{
		$return_count = 6;
	}

	return $return_count;
}

function calculateBoardStickerLength($sticker_length)
{
	$return_count = 1;
	if($sticker_length >= 7 && $sticker_length < 9)
	{
		$return_count = 2;
	}
	elseif($sticker_length >= 10 && $sticker_length < 12)
	{
		$return_count = 3;
	}
	elseif($sticker_length >= 13 && $sticker_length < 15)
	{
		$return_count = 4;
	}
	elseif($sticker_length >= 16 && $sticker_length < 18)
	{
		$return_count = 5;
	}
	elseif($sticker_length >= 19)
	{
		$return_count = 6;
	}

	return $return_count * 3;
}