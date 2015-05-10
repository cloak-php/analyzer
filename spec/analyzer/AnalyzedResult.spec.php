<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\analyzer\AnalyzedResult;
use cloak\analyzer\result\FileResult;
use cloak\analyzer\result\LineResult;


describe(AnalyzedResult::class, function() {
    beforeEach(function() {
        $this->rootDirectory = __DIR__ . '/../fixtures/src/';
        $this->fixtureFilePath = $this->rootDirectory . 'foo.php';
    });

    describe('#fromArray', function() {
        beforeEach(function() {
            $results = [
                $this->fixtureFilePath => [
                    1 => LineResult::EXECUTED
                ]
            ];
            $this->returnValue = AnalyzedResult::fromArray($results);
        });
        it('return cloak\driver\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf(AnalyzedResult::class);
        });
    });

    describe('#addFile', function() {
        beforeEach(function() {
            $this->result = new AnalyzedResult();
            $this->result->addFile(new FileResult($this->fixtureFilePath));
        });
        it('add file', function() {
            expect($this->result->getFileCount())->toEqual(1);
        });
    });

    describe('#isEmpty', function() {
        context('when empty', function() {
            beforeEach(function() {
                $this->result = new AnalyzedResult();
            });
            it('return true', function() {
                expect($this->result->isEmpty())->toBeTrue();
            });
        });
        context('when not empty', function() {
            beforeEach(function() {
                $this->result = new AnalyzedResult();
                $this->result->addFile(new FileResult($this->fixtureFilePath));
            });
            it('return false', function() {
                expect($this->result->isEmpty())->toBeFalse();
            });
        });
    });

    describe('#includeFiles', function() {
        beforeEach(function() {
            $this->result = new AnalyzedResult();
            $this->result->addFile(new FileResult($this->fixtureFilePath));
        });
        context('when all conditions matched', function() {
            it('returns the included results', function() {
                $result = $this->result->includeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('foo.php');
                    }
                ]);
                expect($result->getFileCount())->toBe(1);
            });
        });
        context('when not conditions matched', function() {
            it('returns an empty result', function() {
                $result = $this->result->includeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('bar.php');
                    }
                ]);
                expect($result->getFileCount())->toBe(0);
            });
        });
    });

    describe('#excludeFiles', function() {
        beforeEach(function() {
            $this->result = new AnalyzedResult();
            $this->result->addFile(new FileResult($this->fixtureFilePath));
        });
        context('when all conditions matched', function() {
            it('returns the excluded results', function() {
                $result = $this->result->excludeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('foo.php');
                    }
                ]);
                expect($result->getFileCount())->toBe(0);
            });
        });
        context('when not conditions matched', function() {
            it('returns the raw results', function() {
                $result = $this->result->excludeFiles([
                    function(FileResult $result) {
                        return $result->matchPath('bar.php');
                    }
                ]);
                expect($result->getFileCount())->toBe(1);
            });
        });
    });

});
