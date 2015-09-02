<?php

namespace Cielo\Http;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
interface OnlyPostHttpClientInterface
{
    /**
     * @param  string    $url
     * @param  array     $fields
     * @param  \string[] $headers
     * @return string
     */
    public function __invoke($url, array $headers = [], array $fields = []);
}
