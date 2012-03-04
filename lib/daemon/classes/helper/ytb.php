<?php
define('ERROR_FILE_NOT_FOUND',1);
define('ERROR_CANT_MAKE_THUMBNAIL',2);
define('ERROR_CANT_CREATE_OUTPUT_PATH',3);

define('upload_path',__DIR__.'/../../../../web/uploads/youtube-dl');
define('youtube_dl_path',__DIR__.'/youtube-dl ');
define('directory_postfix','.dir');
define('default_thumbnail_filename','original.jpg');
$you_tube_base_url = 'http://www.youtube.com/watch?v=';

function is_ClipExists($filename)
{
	if(file_exists($filename.'.flv'))return '.flv';
	elseif(file_exists($filename.'.mp4'))return '.mp4';
	//TODO: search file by extension or add search by other video exension
	else return false;
}

function downloadfile($filename,$time,$outputfile,$print_to_console=false)
{
	global $you_tube_base_url;
	$output = array();
	$return_val = 0;
	$original_filename = $filename;

	$stopped = false;
	$count=1;
	$default_size = 30000;
	while (!$stopped && ($count<=15)) {
		$size = $count*$default_size;

		exec('python '.youtube_dl_path." {$you_tube_base_url}{$original_filename} -o '".upload_path."/{$original_filename}.%(ext)s' --start-time $time --download-length $size".' > /var/log/vdaemon-downloader.log', $output, $return_val);

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
		exec("ffmpeg -i {$filename}{$ext} -ss 00:00:00.001 -t 00:00:00.001 -f image2 $filename".directory_postfix.'/'.$outputfile.' 2> /var/log/vdaemon-ffmpeg.log', $output, $return_val);
		if(file_exists($filename.directory_postfix.'/'.$outputfile)){
			$stopped = true;
		}else
			$count++;
		if(file_exists($filename.$ext))unlink($filename.$ext);
	}
	if($count>15){
		exec('python '.youtube_dl_path." {$you_tube_base_url}{$original_filename} -o '".upload_path."/{$original_filename}.%(ext)s'".' > /var/log/vdaemon-downloader.log', $output, $return_val);
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
		unlink($filename.$ext);
		exec("ffmpeg -i {$filename}{$ext} -ss 00:00:00.001 -t 00:00:00.001 -f image2 $filename".directory_postfix.'/'.$outputfile.' 2> /var/log/vdaemon-ffmpeg.log', $output, $return_val);
		unlink($filename);
		if(!file_exists($filename.directory_postfix.'/'.$outputfile)){
			return ERROR_CANT_MAKE_THUMBNAIL;
		}
	}
	return 0;
}

$options = getopt("f:t:o:");

if(!$options || !$options['f']){
	$output_str = <<<OUTPUT
Youtube ThumnailMaker, (c) 2012

Parameters:
-f - short filename youtubefile
-t - time in second (float)
-o - output file, default - clip.png

OUTPUT;
	//TODO -p - if p = 1  - print file to console
	echo $output_str;
}
else{
	$time = isset($options['t'])&&is_numeric($options['t'])?$options['t']:0;
	$outputfile = isset($options['o'])&&$options['o']?$options['o']:default_thumbnail_filename;
	$pint_to_colsole = false;//TODO
	$result = downloadfile($options['f'],$time,$outputfile,$pint_to_colsole);
	if($result===0){
		//COMPLETE
	}else{
		switch ($result){
			case ERROR_FILE_NOT_FOUND: break;
			case ERROR_CANT_MAKE_THUMBNAIL: break;
			case ERROR_CANT_CREATE_OUTPUT_PATH: break;
		}
	}
}
