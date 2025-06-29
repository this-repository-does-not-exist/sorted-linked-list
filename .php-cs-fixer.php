<?php declare(strict_types=1);

/*
 * This file is part of SortedLinkedList.
 *
 * (c) 2025 Kuba
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

require __DIR__ . '/vendor/autoload.php';

use PhpCsFixer\Finder;
use PhpCsFixerConfig\Factory;

return Factory::createForLibrary('SortedLinkedList', 'Kuba', 2025)
    ->setFinder(
        Finder::create()
            ->files()
            ->ignoreDotFiles(false)
            ->in(__DIR__),
    );
