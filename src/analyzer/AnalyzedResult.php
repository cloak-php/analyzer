<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\analyzer;

use cloak\analyzer\result\FileResult;
use cloak\analyzer\result\FileNotFoundException;
use cloak\analyzer\result\collection\FileResultCollection;
use Closure;


/**
 * Class AnalyzedResult
 * @package cloak\analyzer
 */
class AnalyzedResult
{

    /**
     * @var FileResultCollection
     */
    private $files;


    /**
     * @param \cloak\analyzer\result\FileResult[] $files
     */
    public function __construct(array $files = [])
    {
        $this->files = new FileResultCollection($files);
    }

    /**
     * @param array $results
     * @return AnalyzedResult
     */
    public static function fromArray(array $results)
    {
        $files = static::parseResult($results);
        return new static($files);
    }

    /**
     * @param array $results
     * @return \cloak\analyzer\result\FileResult[]
     */
    protected static function parseResult(array $results)
    {
        $files = [];

        foreach ($results as $path => $lineResults) {
            try {
                $file = new FileResult($path, $lineResults);
            } catch (FileNotFoundException $exception) {
                continue;
            }
            $key = $file->getPath();
            $files[$key] = $file;
        }

        return $files;
    }

    /**
     * @param FileResult $file
     */
    public function addFile(FileResult $file)
    {
        $this->files->add($file);
    }

    /**
     * @return FileResultCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param callable $filter
     * @return AnalyzedResult
     */
    public function includeFile(Closure $filter)
    {
        $files = $this->files->includeFile($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return AnalyzedResult
     */
    public function includeFiles(array $filters)
    {
        $newResult = $this;

        foreach ($filters as $filter) {
            $newResult = $this->includeFile($filter);
        }

        return $newResult;
    }

    /**
     * @param callable $filter
     * @return AnalyzedResult
     */
    public function excludeFile(Closure $filter)
    {
        $files = $this->files->excludeFile($filter);
        return $this->createNew($files);
    }

    /**
     * @param array $filters
     * @return AnalyzedResult
     */
    public function excludeFiles(array $filters)
    {
        $newResult = $this;

        foreach ($filters as $filter) {
            $newResult = $this->excludeFile($filter);
        }

        return $newResult;
    }

    /**
     * @return int
     */
    public function getFileCount()
    {
        return $this->files->count();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->files->isEmpty();
    }

    /**
     * @param FileResultCollection $collection
     * @return AnalyzedResult
     */
    private function createNew(FileResultCollection $collection)
    {
        $files = $collection->toArray();
        return new self($files);
    }

}
