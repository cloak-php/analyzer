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


/**
 * Class Analyzer
 * @package cloak\analyzer
 */
final class Analyzer implements AnalyzeDriver
{

    /**
     * @var Analyzeadapter
     */
    private $adapter;


    /**
     * @var boolean
     */
    private $started = false;

    /**
     * @var array
     */
    private $analyzeResult = [];


    /**
     * @param Analyzeadapter $adapter
     */
    public function __construct(Analyzeadapter $adapter)
    {
        $this->adapter = $adapter;
    }


    public function start()
    {
        $this->adapter->start();
        $this->started = true;
    }

    public function stop()
    {
        $result = $this->adapter->stop();
        $this->analyzeResult = $result;
        $this->started = false;
    }

    /**
     * @return boolean
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * @return AnalyzedResult
     */
    public function getAnalyzeResult()
    {
        return AnalyzedResult::fromArray($this->analyzeResult);
    }

}
