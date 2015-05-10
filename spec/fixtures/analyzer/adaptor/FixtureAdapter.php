<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\spec\analyzer\adaptor;


use cloak\analyzer\AnalyzeAdapter;
use cloak\analyzer\adaptor\AdapterNotAvailableException;


class FixtureAdapter implements AnalyzeAdapter
{

    public function __construct()
    {
        throw new AdapterNotAvailableException();
    }

    public function start()
    {
    }

    public function stop()
    {
    }

}
