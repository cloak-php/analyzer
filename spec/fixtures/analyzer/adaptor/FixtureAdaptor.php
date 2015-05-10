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


use cloak\analyzer\AnalyzeAdaptor;
use cloak\analyzer\adaptor\AdaptorNotAvailableException;


class FixtureAdaptor implements AnalyzeAdaptor
{

    public function __construct()
    {
        throw new AdaptorNotAvailableException();
    }

    public function start()
    {
    }

    public function stop()
    {
    }

}
