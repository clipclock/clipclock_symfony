<?php

class refreshFramesTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
	  new sfCommandOption('force', null, sfCommandOption::PARAMETER_OPTIONAL, 'Force update for all elements', ''),
      // add your own options here
    ));

    $this->namespace        = 'refresh';
    $this->name             = 'frames';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [refreshFrames|INFO] task does things.
Call it with:

  [php symfony refreshFrames|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

	  $c = new Criteria();
	  $c->clearSelectColumns();
	  $c->addSelectColumn(SceneTimePeer::ID);
	  $c->addSelectColumn(SceneTimePeer::SCENE_TIME);
	  $c->addSelectColumn(ClipPeer::URL);
	  $c->add(SceneTimePeer::SCENE_TIME, null, Criteria::ISNOTNULL);
	  $c->addJoin(SceneTimePeer::CLIP_ID, ClipPeer::ID, Criteria::INNER_JOIN);
	  $c->addDescendingOrderByColumn(SceneTimePeer::ID);
	  $scene_times = BasePeer::doSelect($c)->fetchAll(PDO::FETCH_ASSOC);


	  foreach($scene_times as $scene_time)
	  {
		  if(!file_exists(__DIR__.'/../../web'.ImagePreview::c14n($scene_time['id'], 'medium', 'scene')) ||
		  !file_exists(__DIR__.'/../../web'.ImagePreview::c14n($scene_time['id'], 'big', 'scene')) || $options['force'])
		  {

			  $amqp_publisher = new AMQPPublisher();
			  $amqp_publisher->jobScene(
				  $scene_time['id'],
				  $scene_time['url'],
				  $scene_time['scene_time']);
		  }
	  }

	  echo "Done!
";
    // add your code here
  }
}
