<?php declare(strict_types=1);

namespace OpenEngine\Http\Message\Request\Tests;

use OpenEngine\Http\Message\Request\Request;
use OpenEngine\Http\Message\Request\RequestFactory;
use OpenEngine\Http\Message\Uri\UriFactory;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testFactory(): void
    {
        $request = (new RequestFactory())->createRequest('get', (new UriFactory)->createUri('http://localhost:8021'));
        self::assertStringEndsWith('GET', $request->getMethod());
        self::assertArrayHasKey('host', $request->getHeaders());
        self::assertStringEndsWith('localhost', $request->getHeaderLine('host'));
    }

    public function testTarget(): void
    {
        $request = new Request((new UriFactory)->createUri('http://localhost:8021/test/index.php?foo=bar'));
        self::assertStringEndsWith('/test/index.php?foo=bar', $request->getRequestTarget());
        self::assertStringEndsWith('/foo', $request->withRequestTarget('/foo')->getRequestTarget());
    }

    public function testBase(): void
    {
        $request = new Request((new UriFactory)->createUri('http://localhost:8021/test/index.php?foo=bar'));
        self::assertStringEndsWith('/test/index.php?foo=bar', $request->getRequestTarget());
    }
}
