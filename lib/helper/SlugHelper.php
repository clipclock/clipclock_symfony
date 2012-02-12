<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 12.02.12
 * Time: 1:16
 * To change this template use File | Settings | File Templates.
 */

function slugCharacters($string)
{
	$map = array(
		'/à|á|ã|â/' => 'a',
		'/è|é|ê|ẽ|ë/' => 'e',
		'/ì|í|î/' => 'i',
		'/ò|ó|ô|õ|ø/' => 'o',
		'/ù|ú|ũ|û/' => 'u',
		'/ç/' => 'c',
		'/ñ/' => 'n',
		'/ä|æ/' => 'ae',
		'/ö/' => 'oe',
		'/ü/' => 'ue',
		'/Ä/' => 'Ae',
		'/Ü/' => 'Ue',
		'/Ö/' => 'Oe',
		'/ß/' => 'ss',
		'/[^\w\s]/' => ' ',
	);

	return preg_replace(array_keys($map), array_values($map), $string);
}

function slugify($text)
{
	$text = slugCharacters($text);
	// replace all non letters or digits by -
	$text = preg_replace('/\W+/', '-', $text);

	// trim and lowercase
	$text = strtolower(trim($text, '-'));

	return $text;
}