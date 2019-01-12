<?php declare(strict_types=1);

namespace OpenEngine\Http\Message\Uri;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class UriFactory implements UriFactoryInterface
{
    /**
     * Create a new URI.
     *
     * @param string $uri
     * @return UriInterface
     * @throws \InvalidArgumentException If the given URI cannot be parsed.
     */
    public function createUri(string $uri = ''): UriInterface
    {
        if (empty($uri)) {
            if (!isset($_SERVER['SERVER_NAME'], $_SERVER['REQUEST_URI'])) {
                throw new \RuntimeException('Can not create Uri');
            }

            $uri .= $this->getScheme() . '://' . $_SERVER['SERVER_NAME'] . '';
            $uri .= empty($_SERVER['SERVER_PORT']) ? '' : ':' . $_SERVER['SERVER_PORT'];
            $uri .= $_SERVER['REQUEST_URI'] ?? '';
        }

        return new Uri($uri);
    }

    /**
     * @return string
     */
    private function getScheme(): string
    {
        return $_SERVER['REQUEST_SCHEME'] ?? 'http';
    }
}
