<?php

namespace PhpOption\Tests;

use PhpOption\None;
use PhpOption\Some;
use PHPUnit\Framework\TestCase;

class NoneTest extends TestCase
{
    private $none;

    public function testGet()
    {
        $this->expectException(\RuntimeException::class);
        $none = None::create();
        $none->get();
    }

    public function testGetOrElse()
    {
        $none = None::create();
        $this->assertEquals('foo', $none->getOrElse('foo'));
    }

    public function testGetOrCall()
    {
        $none = None::create();
        $this->assertEquals('foo', $none->getOrCall(function () {
            return 'foo';
        }));
    }

    public function testGetOrThrow()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not Found!');
        None::create()->getOrThrow(new \RuntimeException('Not Found!'));
    }

    public function testIsEmpty()
    {
        $none = None::create();
        $this->assertTrue($none->isEmpty());
    }

    public function testOrElse()
    {
        $option = Some::create('foo');
        $this->assertSame($option, None::create()->orElse($option));
    }

    public function testifDefined()
    {
        $this->assertNull($this->none->ifDefined(function () {
            throw new \LogicException('Should never be called.');
        }));
    }

    public function testForAll()
    {
        $this->assertSame($this->none, $this->none->forAll(function () {
            throw new \LogicException('Should never be called.');
        }));
    }

    public function testMap()
    {
        $this->assertSame($this->none, $this->none->map(function () {
            throw new \LogicException('Should not be called.');
        }));
    }

    public function testFlatMap()
    {
        $this->assertSame($this->none, $this->none->flatMap(function () {
            throw new \LogicException('Should not be called.');
        }));
    }

    public function testFilter()
    {
        $this->assertSame($this->none, $this->none->filter(function () {
            throw new \LogicException('Should not be called.');
        }));
    }

    public function testFilterNot()
    {
        $this->assertSame($this->none, $this->none->filterNot(function () {
            throw new \LogicException('Should not be called.');
        }));
    }

    public function testSelect()
    {
        $this->assertSame($this->none, $this->none->select(null));
    }

    public function testReject()
    {
        $this->assertSame($this->none, $this->none->reject(null));
    }

    public function testForeach()
    {
        $none = None::create();

        $called = 0;
        foreach ($none as $value) {
            $called++;
        }

        $this->assertEquals(0, $called);
    }

    public function testFoldLeftRight()
    {
        $this->assertSame(1, $this->none->foldLeft(1, function () {
            $this->fail();
        }));
        $this->assertSame(1, $this->none->foldRight(1, function () {
            $this->fail();
        }));
    }

    protected function setUp(): void
    {
        $this->none = None::create();
    }
}
