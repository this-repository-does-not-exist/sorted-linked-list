# SortedLinkedList

![PHP version](https://img.shields.io/badge/php-%5E8.4-blue)
[![CI status](https://github.com/this-repository-does-not-exist/sorted-linked-list/actions/workflows/ci.yaml/badge.svg)](https://github.com/this-repository-does-not-exist/sorted-linked-list/actions/workflows/ci.yaml)

Library providing `SortedLinkedList` (linked list that keeps values sorted).


## Installation
Add the repository to `composer.json`:
```json
"repositories": [
    {
        "type": "github",
        "url":  "git@github.com:this-repository-does-not-exist/sorted-linked-list.git"
    }
],
```
Install it with Composer:
```bash
composer require kuba/sorted-linked-list:dev-main
```


## Example usage
```php
<?php

$list = new SortedLinkedList\SortedLinkedList();

// we can add element to the list:
$list->add(4);
$list->add(2);
$list->add(4);
$list->add(1);

// we can delete element from the list:
$list->delete(2);

// we can check if value is present in the list:
$list->exists(1); // true
$list->exists(2); // false
$list->exists(3); // false
$list->exists(4); // true

// we can get all the values:
$list->getAllValues(); // [1, 4, 4]

// note: deleting value deletes only single occurrence:
$list->delete(4);
$list->getAllValues(); // [1, 4]
```

## Custom sorting
By default, sorting is done using the `<=>` operator.
To have custom sorting of elements implement custom [`Comparator`](./src/Comparator.php), e.g.:
```php
<?php

class ReverseSortingComparator implements SortedLinkedList\Comparator
{
    public function compare(int|string $x, int|string $y): int
    {
        return $y <=> $x;
    }
}
```
