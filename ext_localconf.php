<?php

defined('TYPO3_MODE') || defined('TYPO3') || die('Access denied.');

call_user_func(function () {
    if (
        !class_exists(\TYPO3\CMS\Core\Information\Typo3Version::class)
        || version_compare(
            \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                \TYPO3\CMS\Core\Information\Typo3Version::class
            )->getBranch(),
            '10.4',
            '<'
        )
    ) {
        $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $dispatcher->connect(
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::class,
            'tcaIsBeingBuilt',
            \IchHabRecht\HideUsedContent\EventListener\TcaColPosEventListener::class,
            'initializeColPosCache'
        );
    }

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['record_is_used']['hide_used_content'] =
        \IchHabRecht\HideUsedContent\Hooks\PageLayoutViewHook::class . '->hideUsedContent';
});
