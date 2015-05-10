<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */


use cloak\analyzer\result\FileResult;
use cloak\analyzer\result\collection\FileResultCollection;

describe(FileResultCollection::class, function() {

    describe('#includeFiles', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/../../../fixtures/src/';
            $filePath = $rootDirectory . 'foo.php';

            $this->result = new FileResult($filePath);
            $this->collection = new FileResultCollection([
                $this->result->getPath() => $this->result
            ]);
        });
        context('when all conditions matched', function() {
            it('returns the included results', function() {
                $result = $this->collection->includeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('foo.php');
                    }
                ]);
                expect($result)->toHaveLength(1);
            });
        });
        context('when not conditions matched', function() {
            it('returns an empty result', function() {
                $result = $this->collection->includeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('bar.php');
                    }
                ]);
                expect($result)->toBeEmpty();
            });
        });
    });

    describe('#excludeFiles', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/../../../fixtures/src/';
            $filePath = $rootDirectory . 'foo.php';

            $this->result = new FileResult($filePath);
            $this->collection = new FileResultCollection([
                $this->result->getPath() => $this->result
            ]);
        });
        context('when all conditions matched', function() {
            it('returns the excluded results', function() {
                $result = $this->collection->excludeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('foo.php');
                    }
                ]);
                expect($result)->toBeEmpty();
            });
        });
        context('when not conditions matched', function() {
            it('returns the raw results', function() {
                $result = $this->collection->excludeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('bar.php');
                    }
                ]);
                expect($result)->toHaveLength(1);
            });
        });
    });

});
