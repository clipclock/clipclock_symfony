<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 08.11.11
 * Time: 12:13
 * To change this template use File | Settings | File Templates.
 */
 
class daemonModelInvites extends  daemonModelBase {

	public function addAllUserIds(array $invites_ids, $author_id, $created_at)
	{
		if(!count($invites_ids))
		{
			throw new daemonExceptionFatalLogic('Empty invites_ids!');
		}

		$sql = 'INSERT INTO invites (created_at, sf_guard_user_profile_id, ext_id) VALUES';
		$i = 3;
		$values = array();
		foreach($invites_ids as $invited_id)
		{
			$sql = $sql . ' ($'.($i-2).', $'.($i-1).', $'.$i.'),';

			$values[$i - 2] = $created_at;
			$values[$i - 1] = $author_id;
			$values[$i] = $invited_id;
			$i = $i * 2;
		}

		$sql = substr($sql, 0, -1);

		return $this->execute($sql, $values);
	}

	public function addOneUserId($invited_id, $author_id, $created_at)
	{
		$sql = 'SELECT 1 FROM invites WHERE sf_guard_user_profile_id = $1 and ext_id = $2 LIMIT 1;';
		$values = array($author_id, $invited_id);
		$exists = $this->execute($sql, $values);

		if(count($exists))
		{
			$sql = 'UPDATE invites SET created_at = $1 WHERE sf_guard_user_profile_id = $2 and ext_id = $3;';
			$values = array($created_at, $author_id, $invited_id);
		}
		else
		{
			$sql = 'INSERT INTO invites (created_at, sf_guard_user_profile_id, ext_id) VALUES ($1, $2, $3);';
			$values = array($created_at, $author_id, $invited_id);
		}

		return $this->execute($sql, $values);
	}
}
