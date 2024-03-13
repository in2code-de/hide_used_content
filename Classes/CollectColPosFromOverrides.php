<?php

declare(strict_types=1);

namespace IchHabRecht\HideUsedContent;

use TYPO3\CMS\Core\Configuration\Event\AfterTcaCompilationEvent;

class CollectColPosFromOverrides
{
    public function __invoke(AfterTcaCompilationEvent $event): void
    {
        $tca = $event->getTca();
        foreach ($tca as $table => $tableConfiguration) {
            foreach ($tableConfiguration['columns'] ?? [] as $field => $fieldConfiguration) {
                if ($this->isInlineField($fieldConfiguration) && $this->isValidForeignTable($fieldConfiguration)) {
                    $colPos = $fieldConfiguration['config']['overrideChildTca']['columns']['colPos']['config']['default'] ?? null;
                    if (null !== $colPos) {
                        $tca[$table]['ctrl']['EXT']['hide_used_content']['colPos'][(int) $colPos] = $field;
                    }
                }
            }
        }
        $event->setTca($tca);
    }

    public function isInlineField(array $fieldConfiguration): bool
    {
        return 'inline' === ($fieldConfiguration['config']['type'] ?? null);
    }

    protected function isValidForeignTable(array $fieldConfiguration): bool
    {
        return !empty($fieldConfiguration['config']['foreign_field'])
            && 'tt_content' === ($fieldConfiguration['config']['foreign_table'] ?? null);
    }
}
