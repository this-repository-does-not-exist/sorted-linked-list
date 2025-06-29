<?php declare(strict_types=1);

/*
 * This file is part of SortedLinkedList.
 *
 * (c) 2025 Kuba
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace SortedLinkedList;

/**
 * @no-named-arguments
 */
interface Comparator
{
    /**
     * It should return -1, 0 or 1 when $x is less than, equal to, or greater than $y, respectively.
     */
    public function compare(int|string $x, int|string $y): int;
}
