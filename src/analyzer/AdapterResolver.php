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

use cloak\analyzer\adaptor\AdapterNotFoundException;
use cloak\analyzer\adaptor\AdapterNotAvailableException;


/**
 * Class AdapterResolver
 * @package cloak\analyzer
 */
class AdapterResolver implements AdapterResolvable
{

    /**
     * @var array
     */
    private $adaptors;


    /**
     * @param array $adaptors
     */
    public function __construct(array $adaptors)
    {
        $this->adaptors = $adaptors;
    }

    /**
     * @return \cloak\analyzer\AnalyzeAdapter
     * @throws AdapterNotFoundException
     */
    public function detect()
    {
        $result = null;
        $exceptions = [];

        foreach ($this->adaptors as $adaptor) {
            try {
                $result = new $adaptor();
                break;
            } catch (AdapterNotAvailableException $exception) {
                $exceptions[] = $exception->getMessage();
            }
        }

        if (count($exceptions) === count($this->adaptors)) {
            throw new AdapterNotFoundException($exceptions);
        }

        return $result;
    }

}
