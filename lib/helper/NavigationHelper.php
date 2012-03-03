<?php

function buildNavigationPath($subject)
{
    $slugs = array();

    switch(get_class($subject)) {
        case 'SfGuardUserProfile' :
			use_helper('I18N');

			$boards_count = BoardPeer::getCountByUserId($subject->getId());
            $pins_count = ScenePeer::getCountByUserId($subject->getId());
            $likes_count = SceneLikePeer::getCountByUserId($subject->getId());
            $comments_count = SceneCommentPeer::getCountByUserId($subject->getId());

            $slugs[] = format_number_choice('[0] No Boards|[1]%count% Board|(1,+Inf]%count% Boards', array('%count%' => $boards_count), $boards_count);
            $slugs[] = format_number_choice('[0] No Pins|[1]%count% Pin|(1,+Inf]%count% Pins', array('%count%' => $pins_count), $pins_count);
            $slugs[] = format_number_choice('[0] No Likes|[1]%count% Like|(1,+Inf]%count% Likes', array('%count%' => $likes_count), $likes_count);
            $slugs[] = format_number_choice('[0] No Comments|[1]%count% Comment|(1,+Inf]%count% Comments', array('%count%' => $comments_count), $comments_count);

//			$slugs[] = format_number_choice('[0] No Boards|[1]%count% Board|(1,+Inf]%count% Boards', array('%count%' => $boards_count), $boards_count);
//			$slugs[] = link_to(format_number_choice('[0] No Pins|[1]%count% Pin|(1,+Inf]%count% Pins', array('%count%' => $pins_count), $pins_count), array('sf_route' => 'user', 'nick' => $subject->getNick()));
//			$slugs[] = link_to(format_number_choice('[0] No Likes|[1]%count% Like|(1,+Inf]%count% Likes', array('%count%' => $likes_count), $likes_count), array('sf_route' => 'user', 'nick' => $subject->getNick()));
//			$slugs[] = link_to(format_number_choice('[0] No Comments|[1]%count% Comment|(1,+Inf]%count% Comments', array('%count%' => $comments_count), $comments_count), array('sf_route' => 'user', 'nick' => $subject->getNick()));

            return '<ul class="user-title-menu"><li>' . implode('</li><li>', $slugs) . '</li></ul>';

        case 'Board' :
            $slugs[] = link_to($subject->getSfGuardUserProfile()->getNick(), array('sf_route' => 'user', 'nick' => $subject->getSfGuardUserProfile()->getNick()));
            $slugs[] = $subject;
            return implode(' / ', $slugs);


        case 'Scene' :
            $slugs[] = link_to($subject->getSfGuardUserProfile()->getNick(), array('sf_route' => 'user', 'nick' => $subject->getSfGuardUserProfile()->getNick()));
            $slugs[] = link_to($subject->getBoard(), array('sf_route' => 'board', 'username_slug' => $subject->getSfGuardUserProfile()->getNick(), 'id' => $subject->getBoardId()));
            $slugs[] = link_to($subject->getSceneTime()->getReclip()->getClip()->getName(), array('sf_route' => 'scene', 'username_slug' => $subject->getSfGuardUserProfile()->getNick(), 'id' => $subject->getId(), 'board_id' => $subject->getBoardId()));
            $slugs[] = $subject->getSceneTime();

            return implode(' / ', $slugs);
    }

    return implode('', $slugs);
}