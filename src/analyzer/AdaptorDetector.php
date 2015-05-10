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

use cloak\analyzer\adaptor\AdaptorNotFoundException;
use cloak\analyzer\adaptor\AdaptorNotAvailableException;


/**
 * Class AdaptorDetector
 * @package cloak\analyzer
 */
class AdaptorDetector implements AdaptorDetectorInterface
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
     * @return \cloak\driver\AnalyzeAdaptor
     * @throws AdaptorNotFoundException
     */
    public function detect()
    {
        $result = null;
        $exceptions = [];

        foreach ($this->adaptors as $adaptor) {
            try {
                $result = new $adaptor();
                break;
            } catch (AdaptorNotAvailableException $exception) {
                $exceptions[] = $exception->getMessage();
            }
        }

        if (count($exceptions) === count($this->adaptors)) {
            throw new AdaptorNotFoundException($exceptions);
        }

        return $result;
    }

}
