<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 22.02.12
 * Time: 17:26
 * To change this template use File | Settings | File Templates.
 */

class daemonHelperSceneExtract
{
	public $temp_frame_path = '';
	public $temp_dir_path = '';
	public function __construct()
	{
	}

	public function retrieveFrame($url, $time)
	{
		exec('php '.__DIR__.'/ytb.php -f '.$url.' -t '.$time);

		$this->temp_frame_path = __DIR__.'/../../../../web/uploads/youtube-dl/'.$url.'.dir/original.jpg';
		$this->temp_dir_path = __DIR__.'/../../../../web/uploads/youtube-dl/'.$url.'.dir';
	}
}