<?php

class refreshAvatarsTask extends sfBaseTask
{
	protected function configure()
	{
		// // add your own arguments here
		// $this->addArguments(array(
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));

		$this->addOptions(array(
			new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
			new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
			new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
			// add your own options here
		));

		$this->namespace        = 'refresh';
		$this->name             = 'avatars';
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
		sfContext::createInstance($this->configuration);

		$c = new Criteria();
		$c->addDescendingOrderByColumn(TokenPeer::CREATED_AT);
		$tokens = TokenPeer::doSelect($c);

		foreach($tokens as $token)
		{
			if(!file_exists(__DIR__.'/../../web'.ImagePreview::c14n($token->getUserId(), 'medium', 'avatar')) ||
					!file_exists(__DIR__.'/../../web'.ImagePreview::c14n($token->getUserId(), 'big', 'avatar')))
			{
				$melody = sfMelody::getInstance($token->getName(), array('token' => $token));
				$action_map = ProfileMapper::$action_map;
				$photo_action = $action_map[$melody->getName()]['photo'];
				$avatar_action = Profile::$action_map[$melody->getName()]['avatar'];
				$photo_url = $melody->getPhoto()->$photo_action;
				$avatar_url = $melody->getAvatar()->$avatar_action;

				$amqp_publisher = new AMQPPublisher();
				$amqp_publisher->jobAvatar(
					$token->getUserId(),
					$photo_url,
					$avatar_url);
			}
		}

		echo "Done!
";
		// add your code here
	}
}
