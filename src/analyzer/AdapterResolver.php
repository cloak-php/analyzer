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

use cloak\analyzer\adapter\AdapterNotFoundException;
use cloak\analyzer\adapter\AdapterNotAvailableException;


/**
 * Class AdapterResolver
 * @package cloak\analyzer
 */
class AdapterResolver implements AdapterResolvable
{

    /**
     * @var array
     */
    private $adapters;


    /**
     * @param array $adapters
     */
    public function __construct(array $adapters)
    {
        $this->adapters = $adapters;
    }

    /**
     * @return \cloak\analyzer\AnalyzeAdapter
     * @throws AdapterNotFoundException
     */
    public function detect()
    {
        $result = null;
        $exceptions = [];

        foreach ($this->adapters as $adapter) {
            try {
                $result = new $adapter();
                break;
            } catch (AdapterNotAvailableException $exception) {
                $exceptions[] = $exception->getMessage();
            }
        }

        if (count($exceptions) === count($this->adapters)) {
            throw new AdapterNotFoundException($exceptions);
        }

        return $result;
    }

}
