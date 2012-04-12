<?php

class fillVideoDurationTask extends sfBaseTask
{
	protected function configure()
	{

		$this->addOptions(array(
			new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
			new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
			new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
			// add your own options here
		));

		$this->namespace        = 'clips';
		$this->name             = 'fill-duration';
		$this->briefDescription = '';
		$this->detailedDescription = <<<EOF
The [fillVideoDuration|INFO] task fill duration for all clips with youtube as service if duration is 0.
Call it with:

  [php symfony fillVideoDuration|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array())
	{
		// for long time task
		set_time_limit(0);

		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'])->getConnection();

		$url = 'http://gdata.youtube.com/feeds/api/videos/ugEezy2NeRU';

		$results = ClipQuery::create()
				->filterByDuration(0)
				->filterByHide(false)
				->where(ClipPeer::SOURCE_ID . ' = 1')
				->find();

		$doc = new DOMDocument;

		foreach($results as $r){

			$url = "http://gdata.youtube.com/feeds/api/videos/{$r->getUrl()}";

			if (@($doc->load($url))){

				$value = $doc->getElementsByTagNameNS("http://gdata.youtube.com/schemas/2007", "duration")->item(0)->getAttribute('seconds');

				$r->setDuration($value);
				$r->save();

				$this->log("Saved duration for {$r->getUrl()} : $value");

				usleep(5000); // a little pause

			} else {

				$this->log("error: can't load document [$url]");
			}
		}

		$this->log('Done!');
	}
}
