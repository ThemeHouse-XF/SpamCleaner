<?php

/**
 *
 * @see XenForo_SpamHandler_Thread
 */
class ThemeHouse_SpamCleaner_Extend_XenForo_SpamHandler_Thread extends XFCP_ThemeHouse_SpamCleaner_Extend_XenForo_SpamHandler_Thread
{

    public function cleanUp(array $user, array &$log, &$errorKey)
    {
        $GLOBALS['XenForo_SpamHandler_Thread'] = $this;

        return parent::cleanUp($user, $log, $errorKey);
    } /* END cleanUp */
}