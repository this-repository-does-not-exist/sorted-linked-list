<?php declare(strict_types=1);

/*
 * This file is part of SortedLinkedList.
 *
 * (c) 2025 Kuba
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SortedLinkedList\Comparator;
use SortedLinkedList\SortedLinkedList;

/**
 * @internal
 */
#[CoversClass(SortedLinkedList::class)]
final class SortedLinkedListTest extends TestCase
{
    public function testIntegerIsNotAcceptedWhenStringWasAlreadyAddedToTheList(): void
    {
        $list = new SortedLinkedList();
        $list->add('foo');

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('List can only contain string elements, trying to add integer.');

        $list->add(1);
    }

    public function testStringIsNotAcceptedWhenIntegersWereAlreadyAddedToTheList(): void
    {
        $list = new SortedLinkedList();
        $list->add(1);
        $list->add(2);
        $list->add(3);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('List can only contain integer elements, trying to add string.');

        $list->add('foo');
    }

    public function testDeletingNotPresentElement(): void
    {
        $list = new SortedLinkedList();
        $list->add(3000);
        $list->add(10);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Element with value "200" does not exist.');

        $list->delete(200);
    }

    public function testDeletingDeletesOnlyOneElement(): void
    {
        $list = new SortedLinkedList();
        $list->add(1);
        $list->add(1);
        $list->add(1);
        self::assertSame([1, 1, 1], $list->getAllValues());

        $list->delete(1);
        self::assertSame([1, 1], $list->getAllValues());
    }

    /**
     * @param list<int> $values
     */
    #[DataProvider('provideManipulatingTheListCases')]
    public function testManipulatingTheList(array $values): void
    {
        $list = new SortedLinkedList();

        foreach ($values as $value) {
            self::assertFalse($list->exists($value));
            $list->add($value);
            self::assertTrue($list->exists($value));
        }

        $sortedValues = $values;
        \sort($sortedValues);

        self::assertSame($sortedValues, $list->getAllValues());

        foreach ($values as $value) {
            self::assertTrue($list->exists($value));
            $list->delete($value);
            self::assertFalse($list->exists($value));
        }
    }

    /**
     * @return iterable<array{list<int>}>
     */
    public static function provideManipulatingTheListCases(): iterable
    {
        yield 'no elements added' => [[]];
        yield 'elements added in random order' => [[3, 9, 6, 1, 5, 4, 0, 8, 7, 2]];
        yield 'elements added in ascending order' => [\range(1, 1024)];
        yield 'elements added in descending order' => [\range(1024, 1, -1)];
    }

    public function testSortingWithCustomComparator(): void
    {
        $list = self::getListWithComparatorBasedOnStringLength();
        $list->add('eeee');
        $list->add('cc');
        $list->add('aaa');
        $list->add('d');
        $list->add('bbbbb');

        self::assertSame(['d', 'cc', 'aaa', 'eeee', 'bbbbb'], $list->getAllValues());
    }

    public function testSortingIsStable(): void
    {
        $list = self::getListWithComparatorBasedOnStringLength();

        $elements = [
            'kdp', 'wzn', 'bqe', 'tml', 'xyr', 'qva', 'jhf', 'upc',
            'lme', 'ozk', 'afj', 'nru', 'vbc', 'gti', 'yds', 'hqx',
            'zlm', 'epw', 'rjd', 'sku', 'cax', 'mno', 'bth', 'vuj',
            'dxr', 'gli', 'tze', 'yqn', 'wfa', 'kju', 'rzb', 'hsv',
            'ixc', 'qwp', 'mef', 'nka', 'oyt', 'lcz', 'bvd', 'txu',
            'psg', 'jmr', 'azn', 'ydu', 'wqi', 'ekc', 'rml', 'hxg',
            'svn', 'btc', 'fdq', 'gzw', 'kvj', 'oml', 'tyx', 'qnd',
            'lep', 'hwb', 'uxo', 'zqi', 'nvm', 'cra', 'pjy', 'xgt',
        ];

        foreach ($elements as $element) {
            $list->add($element);
        }

        self::assertSame($elements, $list->getAllValues());
    }

    private static function getListWithComparatorBasedOnStringLength(): SortedLinkedList
    {
        return new SortedLinkedList(
            new class () implements Comparator {
                public function compare(int|string $x, int|string $y): int
                {
                    return \strlen((string) $x) <=> \strlen((string) $y);
                }
            },
        );
    }
}
