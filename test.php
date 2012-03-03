<?php
$source_id = 1;
$user_id = 7;
$board_id = 37;

$conn = pg_connect('host=localhost port=5432 dbname=viddii user=viddii');
$s = file_get_contents('data.dat');
if($s) $stack = unserialize($s); else $stack = array();
foreach($stack as $key => $stack_info)
{
	if($key > 50 && isset($stack_info['video_id']) && isset($stack_info['time'])  && isset($stack_info['name']))
	{
		$info = array(
			'url' => $stack_info['video_id'],
			'text' => $stack_info['p2'],
			'scene_time' => $stack_info['time'],
			'name' => $stack_info['name']
		);


		$result = pg_query_params($conn, "SELECT id FROM clip WHERE url = $1 LIMIT 1", array($info['url']));
		$exists_clip_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		if(!$exists_clip_id)
		{
			$result = pg_query_params($conn, "INSERT INTO clip (source_id, name, url) VALUES ($1, $2, $3) RETURNING id", array($source_id, $info['name'], $info['url']));
			$exists_clip_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		}

		$result = pg_query_params($conn, "SELECT id FROM reclip WHERE clip_id = $1 LIMIT 1", array($exists_clip_id['id']));
		$exists_reclip_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		if(!$exists_reclip_id)
		{
			$result = pg_query_params($conn, "INSERT INTO reclip (sf_guard_user_profile_id, clip_id) VALUES ($1, $2) RETURNING id", array($user_id, $exists_clip_id['id']));
			$exists_reclip_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		}

		$result = pg_query_params($conn, "SELECT id FROM scene_time WHERE reclip_id = $1 AND scene_time = $2 LIMIT 1", array($exists_reclip_id['id'], $info['scene_time']));
		$scene_time_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		if(!$scene_time_id)
		{
			$result = pg_query_params($conn, "INSERT INTO scene_time (reclip_id, scene_time, created_at) VALUES ($1, $2, NOW() - interval '1 month') RETURNING id", array($exists_reclip_id['id'], $info['scene_time']));
			$scene_time_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		}

		$result = pg_query_params($conn, "SELECT id FROM scene WHERE scene_time_id = $1 AND sf_guard_user_profile_id = $2 LIMIT 1", array($scene_time_id['id'], $user_id));
		$scene_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		if(!$scene_id)
		{
			$result = pg_query_params($conn, "INSERT INTO scene (scene_time_id, board_id, sf_guard_user_profile_id, text, created_at) VALUES ($1, $2, $3, $4, NOW() - interval '1 month') RETURNING id", array($scene_time_id['id'], $board_id, $user_id, $info['text']));
			$scene_id = pg_fetch_array($result, null, PGSQL_ASSOC);
		}
	}
}