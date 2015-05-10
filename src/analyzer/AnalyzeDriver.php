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
 * Interface AnalyzeDriver
 * @package cloak\analyzer
 */
interface AnalyzeDriver
{

    /**
     * @return void
     */
    public function start();

    /**
     * @return void
     */
    public function stop();

    /**
     * @return boolean
     */
    public function isStarted();

    /**
     * @return Result
     */
    public function getAnalyzeResult();

}
