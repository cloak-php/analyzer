<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\analyzer\adapter;

use cloak\analyzer\AnalyzeAdapter;


/**
 * Class HHVMAdapter
 * @package cloak\analyzer\adapter
 */
class HHVMAdapter implements AnalyzeAdapter
{

    public function __construct()
    {
        if (defined('HHVM_VERSION') === false) {
            throw new AdapterNotAvailableException('This adapter requires hhvm');
        }
    }

    public function start()
    {
        fb_enable_code_coverage();
    }

    public function stop()
    {
        $result = fb_get_code_coverage(true);
        fb_disable_code_coverage();

        return $result;
    }

}
