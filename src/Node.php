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
 * @internal
 */
final class Node
{
    public ?self $next = null;

    public function __construct(
        public readonly int|string $value,
    ) {}
}
