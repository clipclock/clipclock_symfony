<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 14.02.12
 * Time: 13:58
 * To change this template use File | Settings | File Templates.
 */

function getTabsHideOffset($tabs, $tab_array_key, $active_tab, $visible_row_lentgh = 4)
{
	$active_key = 0;
	$tabs_from_left = 1;
	$tabs_to_hide = 0;
	foreach($tabs as $key => $tab)
	{
		if($tab[$tab_array_key] == $active_tab)
		{
			$active_key = $key;
			break;
		}
		else
		{
			$tabs_from_left++;
		}
	}
	$tabs_to_hide = $tabs_from_left-$visible_row_lentgh > 0 ? $tabs_from_left-$visible_row_lentgh : 0;
	if($tabs_from_left > $visible_row_lentgh - $visible_row_lentgh/4 && count($tabs) > $visible_row_lentgh && count($tabs) > $tabs_from_left)
	{
		$tabs_to_hide++;
	}

	return array($active_key, $tabs_to_hide);
}

function time_ago($date,$granularity=2) {
	$date = strtotime($date);
	$difference = time() - $date;
	$periods = array('decade' => 315360000,
		'year' => 31536000,
		'month' => 2628000,
		'week' => 604800,
		'day' => 86400,
		'hour' => 3600,
		'minute' => 60,
		'second' => 1);

	$retval = '';
	foreach ($periods as $key => $value) {
		if ($difference >= $value) {
			$time = floor($difference/$value);
			$difference %= $value;
			$retval .= ($retval ? ' ' : '').$time.' ';
			$retval .= (($time > 1) ? $key.'s' : $key);
			$granularity--;
		}
		if ($granularity == '0') { break; }
	}
	return $retval.' ago';
}



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