<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver\result\collection;

use cloak\driver\result\FileResult;
use PhpCollection\Map;
use PhpCollection\AbstractMap;
use PhpOption\Option;
use \Closure;
use \IteratorAggregate;
use \Countable;


/**
 * Class FileResultCollection
 * @package cloak\driver\result\collection
 */
class FileResultCollection implements Countable, IteratorAggregate
{


    /**
     * @var \PhpCollection\Map
     */
    private $collection;

    /**
     * @param \cloak\driver\result\FileResult[] $files
     */
    public function __construct(array $files = [])
    {
        $this->collection = new Map($files);
    }

    /**
     * @param FileResult $file
     */
    public function add(FileResult $file)
    {
        $this->collection->set($file->getPath(), $file);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->toArray();
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        $first = $this->collection->first();
        return $this->returnValue($first);
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        $last = $this->collection->last();
        return $this->returnValue($last);
    }

    /**
     * @param Option $value
     * @return mixed|null
     */
    private function returnValue(Option $value)
    {
        if ($value->isEmpty()) {
            return null;
        }
        $kv = $value->get();

        return array_pop($kv);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->createArray($this->collection);
    }

    /**
     * @param AbstractMap $collection
     * @return array
     */
    protected function createArray(AbstractMap $collection)
    {
        $keys = $collection->keys();
        $values = $collection->values();

        return array_combine($keys, $values);
    }

    /**
     * @return int
     */
    public function isEmpty()
    {
        return $this->collection->isEmpty();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->collection->count();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->collection->getIterator();
    }

    /**
     * @param callable $filter
     * @return FileResultCollection
     */
    public function includeFile(Closure $filter)
    {
        $files = $this->collection->filter($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return FileResultCollection
     */
    public function includeFiles(array $filters)
    {
        $result = $this;

        foreach ($filters as $filter) {
            $result = $result->includeFile($filter);
        }

        return $result;
    }

    /**
     * @param callable $filter
     * @return FileResultCollection
     */
    public function excludeFile(Closure $filter)
    {
        $files = $this->collection->filterNot($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return FileResultCollection
     */
    public function excludeFiles(array $filters)
    {
        $result = $this;

        foreach ($filters as $filter) {
            $result = $result->excludeFile($filter);
        }

        return $result;
    }

    /**
     * @param \PhpCollection\AbstractMap $files
     * @return FileResultCollection
     */
    private function createNew(AbstractMap $files)
    {
        $values = $this->createArray($files);
        return new self($values);
    }

}
