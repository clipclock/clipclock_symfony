<?php
define('ERROR_FILE_NOT_FOUND',1);
define('ERROR_CANT_MAKE_THUMBNAIL',2);
define('ERROR_CANT_CREATE_OUTPUT_PATH',3);

define('upload_path',__DIR__.'/../../../../web/uploads/youtube-dl');
define('youtube_dl_path',__DIR__.'/youtube-dl ');
define('directory_postfix','.dir');
define('default_thumbnail_filename','original.jpg');
define('default_youtube_quality',null);//if NULL then will use default youtube quality

$you_tube_base_url = 'http://www.youtube.com/watch?v=';

function is_ClipExists($filename)
{
	if(file_exists($filename.'.flv'))return '.flv';
	elseif(file_exists($filename.'.mp4'))return '.mp4';
	elseif(file_exists($filename.'.3gp'))return '.3gp';//will be test
	//TODO: search file by extension or add search by other video exension
	else return false;
}

function downloadfile($filename,$time,$outputfile,$videoquality=false,$ffmpegquietmode=false)
{
	global $you_tube_base_url;

	$youtube_postfix_str = '';
	if($videoquality)$youtube_postfix_str .= ' --format '.$videoquality;
	$youtube_postfix_str = $youtube_postfix_str . ' > /var/log/vdaemon-downloader.log';

	$ffmpeg_postfix_str = ' 2> /var/log/vdaemon-ffmpeg.log';
	if($ffmpegquietmode)$ffmpeg_postfix_str .= ' 2>&1';

	$stopped = false;
	$mp4 = null;
	$time_start = null;
	$count=1;
	$default_size = 30000;
	$original_filename = $filename;
	while (!$stopped && ($count<=12)) {

		/**
		 * problem
		 */
		$size = $count*$default_size;

		$start_time_str = ' --start-time '.$time;
		if($mp4)
		{
			$start_time_str = '';
			$size = $size + ($default_size*pow($count-1,4));
		}
		/**
		 * /problem
		 */

		exec('python '.youtube_dl_path." {$you_tube_base_url}{$original_filename}".$start_time_str." -o '".upload_path."/{$original_filename}.%(ext)s' --download-length $size".$youtube_postfix_str);
		$filename = upload_path."/".$original_filename;

		if(!($ext = is_ClipExists($filename)))return ERROR_FILE_NOT_FOUND;

		if(!file_exists($filename.directory_postfix)){
			if(!mkdir($filename.directory_postfix)){
				unlink($filename.$ext);
				return ERROR_CANT_CREATE_OUTPUT_PATH;
			}
		}else{
			if(file_exists($filename.directory_postfix.'/'.$outputfile))unlink($filename.directory_postfix.'/'.$outputfile);
		}

		if(!$time_start)
		{
			$output_str = `ffmpeg -i {$filename}{$ext} 2>&1`;
			$time_start = $time;

			preg_match('*mp4*',$output_str,$mp4_matches);
			if(count($mp4_matches) > 0)
			{
				$mp4 = true;
			}

			if($output_str && preg_match('!,[\s]*start:[\s]*([0-9\.]+)!si',$output_str,$matches)){
				////if detect start time then calculate offset
				if(floatval($matches[1])>0 && $time>floatval($matches[1]))
				{
					$time_start = $time - floatval($matches[1]);
				}
				//if can't detect start time or first frame set offset $time_start = 0
			}

			$time_start_int = intval($time_start);
			$sec = $time_start_int%60+($time_start-$time_start_int);
			$min = $time_start_int/60 % 60;
			$hour = $time_start_int/3600;
		}

		exec("ffmpeg -i {$filename}{$ext} -ss ".sprintf("%02d:%02d:%06.3f",$hour,$min,$sec)." -frames 1 -f image2 $filename".directory_postfix.'/'.$outputfile.$ffmpeg_postfix_str);

		if(file_exists($filename.directory_postfix.'/'.$outputfile))
		{
			$stopped = true;
		}
		else
		{
			$count++;
		}
		if(file_exists($filename.$ext))unlink($filename.$ext);
	}
	if($count>12){
		exec('python '.youtube_dl_path." {$you_tube_base_url}{$original_filename} -o '".upload_path."/{$original_filename}.%(ext)s'".$youtube_postfix_str, $output, $return_val);
		$filename = upload_path."/".$original_filename;

		if(!($ext = is_ClipExists($filename)))return ERROR_FILE_NOT_FOUND;

		if(!file_exists($filename.directory_postfix)){
			if(!mkdir($filename.directory_postfix)){
				unlink($filename.$ext);
				return ERROR_CANT_CREATE_OUTPUT_PATH;
			}
		}else{
			if(file_exists($filename.directory_postfix.'/'.$outputfile))unlink($filename.directory_postfix.'/'.$outputfile);
		}

		if(!$mp4)
		{
			$time_offset_str = '00:00:00.001';
		}
		else
		{
			$time_offset_str = sprintf("%02d:%02d:%06.3f",$hour,$min,$sec);
		}

		exec("ffmpeg -i {$filename}{$ext} -ss ".$time_offset_str." -frames 1 -f image2 $filename".directory_postfix.'/'.$outputfile.$ffmpeg_postfix_str);
		unlink($filename.$ext);
		if(!file_exists($filename.directory_postfix.'/'.$outputfile)){
			return ERROR_CANT_MAKE_THUMBNAIL;
		}
	}
	return 0;
}

$options = getopt("f:t:o:q::Q:");

if(!$options || !$options['f']){
	$output_str = <<<OUTPUT
Youtube ThumnailMaker, (c) 2012

Parameters:
-f - short filename youtubefile
-t - time in second (float)
-o - output file, default - clip.png
-q - ffmpeg quiet mode
-Q - video quality of download video (worst | default | high), default worst
OUTPUT;
	//TODO -p - if p = 1  - print file to console
	echo $output_str;
}
else{

	$time = isset($options['t'])&&is_numeric($options['t'])?floatval($options['t']):0;
	$outputfile = isset($options['o'])&&$options['o']?$options['o']:default_thumbnail_filename;
	$ffmpegquietmode = isset($options['q']);
	$quality = isset($options['Q'])&&$options['Q']?($options['Q']=='default'?'':$options['Q']):default_youtube_quality;
	$pint_body_thumbnail_to_colsole = false;//TODO

	$result = downloadfile($options['f'],$time,$outputfile,$quality,$ffmpegquietmode);
	if($result===0){
		//COMPLETE
	}else{
		//TODO
		switch ($result){
			case ERROR_FILE_NOT_FOUND: echo "Cant' download video file or file is unknown extension";break;
			case ERROR_CANT_MAKE_THUMBNAIL:  echo "Cant' make thumbnail file"; break;
			case ERROR_CANT_CREATE_OUTPUT_PATH: echo "Can't create directory"; break;
		}
	}
}