<?php

function buildNavigationPath($current_scene)
{
    $slugs = array();
    $slugs[] = link_to($current_scene->getSfGuardUserProfile()->getNick(), array('sf_route' => 'user', 'nick' => $current_scene->getSfGuardUserProfile()->getNick()));
    $slugs[] = link_to($current_scene->getBoard(), array('sf_route' => 'board', 'username_slug' => $current_scene->getSfGuardUserProfile()->getNick(), 'id' => $current_scene->getBoardId()));
    $slugs[] = link_to($current_scene->getSceneTime()->getClip()->getName(), array('sf_route' => 'scene', 'username_slug' => $current_scene->getSfGuardUserProfile()->getNick(), 'id' => $current_scene->getId(), 'board_id' => $current_scene->getBoardId()));
    $slugs[] = $current_scene->getSceneTime();

    return implode(' / ', $slugs);
}