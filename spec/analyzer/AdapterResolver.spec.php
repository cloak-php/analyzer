<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\analyzer\AdapterResolver;
use cloak\analyzer\AnalyzeAdapter;
use cloak\analyzer\adaptor\AdapterNotFoundException;
use cloak\spec\analyzer\adaptor\EnableFixtureAdapter;
use cloak\spec\analyzer\adaptor\FixtureAdapter;


describe(AdapterResolver::class, function() {

    describe('#detect', function() {
        context('when enabled', function() {
            beforeEach(function() {
                $this->detector = new AdapterResolver([
                    EnableFixtureAdapter::class
                ]);
            });
            it('return adaptor instance', function() {
                $adaptor = $this->detector->detect();
                expect($adaptor)->toBeAnInstanceOf(AnalyzeAdapter::class);
            });
        });
        context('when not enabled', function() {
            beforeEach(function() {
                $this->detector = new AdapterResolver([
                    FixtureAdapter::class
                ]);
            });
            it('throw cloak\driver\adaptor\AdapterNotFoundException', function() {
                expect(function() {
                    $this->detector->detect();
                })->toThrow(AdapterNotFoundException::class);
            });
        });
    });

});
