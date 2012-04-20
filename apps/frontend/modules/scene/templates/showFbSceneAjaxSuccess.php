<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 19.04.12
 * Time: 16:51
 * To change this template use File | Settings | File Templates.
 */
include_component('board', 'clipStickerLogic', array('current_user' => $user, 'clip_key' => $clip_key, 'fb_user_id' => $fb_user['id'], 'fb_created_at' => $fb_created_at, 'fb_desc' => $fb_desc, 'fb_post_id' => $fb_post_id, 'sf_cache_key' => $clip_key.$user->getId()));