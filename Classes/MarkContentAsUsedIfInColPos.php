<?php

declare(strict_types=1);

namespace IchHabRecht\HideUsedContent;

use TYPO3\CMS\Backend\View\Event\IsContentUsedOnPageLayoutEvent;
use TYPO3\CMS\Core\Database\RelationHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function in_array;

class MarkContentAsUsedIfInColPos
{
    protected readonly array $configuration;

    public function __construct()
    {
        $configuration = [];
        $tca = $GLOBALS['TCA'];
        foreach ($tca as $table => $config) {
            foreach ($config['ctrl']['EXT']['hide_used_content']['colPos'] ?? [] as $colPos => $fieldName) {
                $configuration[$colPos][$table][] = $fieldName;
            }
        }
        $this->configuration = $configuration;
    }

    public function __invoke(IsContentUsedOnPageLayoutEvent $event): void
    {
        if ($event->isRecordUsed()) {
            return;
        }

        $record = $event->getRecord();
        $colPos = (int) $record['colPos'];

        foreach ($this->configuration[$colPos] ?? [] as $table => $fieldArray) {
            $columns = $GLOBALS['TCA'][$table]['columns'];
            foreach ($fieldArray as $field) {
                $fieldConfiguration = $columns[$field]['config'];
                if (empty($record[$fieldConfiguration['foreign_field']])) {
                    continue;
                }

                $relationHandler = GeneralUtility::makeInstance(RelationHandler::class);
                $relationHandler->start(
                    '',
                    $fieldConfiguration['foreign_table'],
                    $fieldConfiguration['MM'] ?? '',
                    $record[$fieldConfiguration['foreign_field']],
                    $table,
                    $fieldConfiguration,
                );
                $valueArray = $relationHandler->getValueArray();
                /** @noinspection TypeUnsafeArraySearchInspection */
                if (in_array($record['uid'], $valueArray)) {
                    $event->setUsed(true);
                }
            }
        }
    }
}
