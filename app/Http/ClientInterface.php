<?php

namespace App\Http;

interface ClientInterface
{
    /**
     * Get Request.
     *
     * @param string $url
     * @param array  $headers
     *
     * @return string|false
     */
    public function get(string $url, array $headers = []);

    /**
     * Post Request.
     *
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return string|false
     */
    public function post(string $url, $data, array $headers = []);
}
