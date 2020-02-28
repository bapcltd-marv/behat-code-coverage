<?php

declare(strict_types=1);
/**
 * Code Coverage Driver.
 *
 * @copyright 2013 Anthon Pang
 * @license BSD-2-Clause
 */

namespace DVDoug\Behat\CodeCoverage;

use DVDoug\Behat\CodeCoverage\Driver\Proxy;
use PHPUnit\Framework\TestCase;

/**
 * Proxy driver test.
 *
 * @group Unit
 */
class ProxyTest extends TestCase
{
    private $driver;
    private $localDriver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->localDriver = $this->createMock('DVDoug\Behat\CodeCoverage\Common\Driver\Stub');

        $this->driver = new Proxy();
        $this->driver->addDriver($this->localDriver);
    }

    public function testStart(): void
    {
        $this->localDriver->expects($this->once())
                          ->method('start');

        $this->driver->start();
    }

    public function testStop(): void
    {
        $coverage = [
                        'SomeClass' => [
                            1 => 1,
                            2 => -1,
                            3 => -2,
                        ],
                    ];

        $this->localDriver->expects($this->once())
                          ->method('stop')
                          ->willReturn($coverage);

        $coverage = $this->driver->stop();

        $this->assertEquals(
            [
                'SomeClass' => [
                    1 => 1,
                    2 => -1,
                    3 => -2,
                ],
            ],
            $coverage
        );
    }
}
