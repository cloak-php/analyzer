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
 * Interface AdapterResolvable
 * @package cloak\analyzer
 */
interface AdapterResolvable
{

    /**
     * @return \cloak\analyzer\analyzeAdaptor
     * @throws \cloak\analyzer\adaptor\AdaptorNotFoundException
     */
    public function detect();

}
