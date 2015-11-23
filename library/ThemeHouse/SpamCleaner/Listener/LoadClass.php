<?php

class ThemeHouse_SpamCleaner_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_SpamCleaner' => array(
                'spam' => array(
                    'XenForo_SpamHandler_Thread'
                ), /* END 'spam' */
                'datawriter' => array(
                    'XenForo_DataWriter_Discussion_Thread'
                ), /* END 'datawriter' */
            ), /* END 'ThemeHouse_SpamCleaner' */
        );
    } /* END _getExtendedClasses */

    public static function loadClassSpam($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_SpamCleaner_Listener_LoadClass', $class, $extend, 'spam');
    } /* END loadClassSpam */

    public static function loadClassDataWriter($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_SpamCleaner_Listener_LoadClass', $class, $extend, 'datawriter');
    } /* END loadClassDataWriter */
}