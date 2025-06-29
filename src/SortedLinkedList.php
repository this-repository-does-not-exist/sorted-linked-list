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
final class SortedLinkedList
{
    private Comparator $comparator;
    private ?Node $firstNode = null;

    public function __construct(
        ?Comparator $comparator = null,
    ) {
        $this->comparator = $comparator ?? new class () implements Comparator {
            public function compare(int|string $x, int|string $y): int
            {
                return $x <=> $y;
            }
        };
    }

    public function add(int|string $newValue): void
    {
        $newNode = new Node($newValue);

        if ($this->firstNode === null) {
            $this->firstNode = $newNode;

            return;
        }

        $listNodesType = \gettype($this->firstNode->value);
        $newNodeType = \gettype($newValue);
        if ($listNodesType !== $newNodeType) {
            throw new \DomainException(\sprintf('List can only contain %s elements, trying to add %s.', $listNodesType, $newNodeType));
        }

        if ($this->comparator->compare($newValue, $this->firstNode->value) < 0) {
            $newNode->next = $this->firstNode;
            $this->firstNode = $newNode;

            return;
        }

        $node = $this->firstNode;

        while ($node->next !== null && $this->comparator->compare($node->next->value, $newValue) <= 0) {
            $node = $node->next;
        }
        $newNode->next = $node->next;
        $node->next = $newNode;
    }

    public function delete(int|string $value): void
    {
        if ($this->firstNode !== null) {
            if ($this->comparator->compare($value, $this->firstNode->value) === 0) {
                $this->firstNode = $this->firstNode->next;

                return;
            }

            $node = $this->firstNode;

            while ($node->next !== null) {
                if ($this->comparator->compare($value, $node->next->value) === 0) {
                    $node->next = $node->next->next;

                    return;
                }

                if ($this->comparator->compare($value, $node->next->value) < 0) {
                    break;
                }

                $node = $node->next;
            }
        }

        throw new \DomainException(\sprintf('Element with value "%s" does not exist.', $value));
    }

    public function exists(int|string $value): bool
    {
        $node = $this->firstNode;

        while ($node !== null) {
            if ($this->comparator->compare($value, $node->value) === 0) {
                return true;
            }
            if ($this->comparator->compare($value, $node->value) < 0) {
                return false;
            }
            $node = $node->next;
        }

        return false;
    }

    /**
     * @return list<int>|list<string>
     */
    public function getAllValues(): array
    {
        $values = [];

        $node = $this->firstNode;

        while ($node !== null) {
            $values[] = $node->value;
            $node = $node->next;
        }

        return $values;
    }
}
