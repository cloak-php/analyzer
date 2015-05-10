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
use cloak\analyzer\adapter\AdapterNotFoundException;
use cloak\spec\analyzer\adapter\EnableFixtureAdapter;
use cloak\spec\analyzer\adapter\FixtureAdapter;


describe(AdapterResolver::class, function() {

    describe('#resolve', function() {
        context('when enabled', function() {
            beforeEach(function() {
                $this->resolver = new AdapterResolver([
                    EnableFixtureAdapter::class
                ]);
            });
            it('return adapter instance', function() {
                $adapter = $this->resolver->resolve();
                expect($adapter)->toBeAnInstanceOf(AnalyzeAdapter::class);
            });
        });
        context('when not enabled', function() {
            beforeEach(function() {
                $this->resolver = new AdapterResolver([
                    FixtureAdapter::class
                ]);
            });
            it('throw cloak\driver\adapter\AdapterNotFoundException', function() {
                expect(function() {
                    $this->resolver->resolve();
                })->toThrow(AdapterNotFoundException::class);
            });
        });
    });

});
