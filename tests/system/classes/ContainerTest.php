<?php

namespace Geeklog\Test;

use Geeklog\Container\Container;
use PHPMailer\PHPMailer\PHPMailer;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use StdClass;

class ContainerTest extends TestCase
{
    /**
     * @var Container
     */
    private $container;

    protected function setUp(): void
    {
        $this->container = new Container();
        $this->container->set('foo', 1);
    }

    public function testHas()
    {
        $this->assertTrue($this->container->has('foo'));
        $this->assertFalse($this->container->has('bar'));

    }

    public function exceptionDataProvider()
    {
        return [
            'baz' => [1, ContainerExceptionInterface::class, 'baz'],
        ];
    }

    public function testGet()
    {
        $this->assertEquals(1, $this->container->get('foo'));
        $this->assertNotEquals(2, $this->container->get('foo'));
    }

    /**
     * @dataProvider exceptionDataProvider
     * @return void
     */
    public function testGetThrowsException()
    {
        $this->expectException(ContainerExceptionInterface::class);
        $this->expectExceptionMessage('baz');

        $item = new StdClass;
        $this->container->set('bar', $item);
        $this->assertInstanceOf(StdClass::class, $this->container->get('baz'));
    }

    public function testSet()
    {
        $this->container->set('mailer', new PHPMailer());
        $this->assertInstanceOf(PHPMailer::class, $this->container->get('mailer'));

        $this->container->set('mailer2', function () {
            return new PHPMailer();
        });
        $this->assertInstanceOf(PHPMailer::class, $this->container->get('mailer'));
    }
}
