<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\analyzer\result;


use Eloquent\Pathogen\Factory\PathFactory;

/**
 * Class FileResult
 * @package cloak\analyzer\result
 */
class FileResult
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var \cloak\analyzer\result\LineResult[]
     */
    private $resultLines;


    /**
     * @param string $path
     * @param array $resultLines
     * @throws \cloak\analyzer\result\FileNotFoundException
     */
    public function __construct($path, array $resultLines = [])
    {
        $absolutePath = PathFactory::instance()->create($path);
        $filePath = $absolutePath->normalize()->string();

        if (file_exists($filePath) === false) {
            throw new FileNotFoundException("'$path' file does not exist");
        }

        $this->path = $filePath;
        $this->resultLines = $this->createLineResults($resultLines);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return (string) $this->path;
    }

    /**
     * @return \cloak\analyzer\result\LineResult[]
     */
    public function getLineResults()
    {
        return $this->resultLines;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function matchPath($path)
    {
        $pathPattern = preg_quote($path, '/');
        $result = preg_match("/" . $pathPattern . "/", $this->getPath());

        return ($result === 0) ? false : true;
    }

    /**
     * @param array $paths
     * @return bool
     */
    public function matchPaths(array $paths)
    {
        foreach ($paths as $path) {
            if ($this->matchPath($path) === false) {
                continue;
            }
            return true;
        }

        return false;
    }

    /**
     * @param array<integer, integer> $resultLines
     * @return \cloak\analyzer\result\LineResult[]
     */
    private function createLineResults(array $resultLines)
    {
        $result = [];

        foreach ($resultLines as $lineNumber => $analyzedResult) {
            $result[] = new LineResult($lineNumber, $analyzedResult);
        }

        return $result;
    }

}
