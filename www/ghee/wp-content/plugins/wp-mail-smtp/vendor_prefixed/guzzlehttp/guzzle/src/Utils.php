<?php

namespace WPMailSMTP\Vendor\GuzzleHttp;

use WPMailSMTP\Vendor\GuzzleHttp\Exception\InvalidArgumentException;
use WPMailSMTP\Vendor\GuzzleHttp\Handler\CurlHandler;
use WPMailSMTP\Vendor\GuzzleHttp\Handler\CurlMultiHandler;
use WPMailSMTP\Vendor\GuzzleHttp\Handler\Proxy;
use WPMailSMTP\Vendor\GuzzleHttp\Handler\StreamHandler;
use WPMailSMTP\Vendor\Psr\Http\Message\UriInterface;
final class Utils
{
    /**
     * Debug function used to describe the provided value type and class.
     *
     * @param mixed $input
     *
     * @return string Returns a string containing the type of the variable and
     *                if a class is provided, the class name.
     */
    public static function describeType($input) : string
    {
        switch (\gettype($input)) {
            case 'object':
                return 'object(' . \get_class($input) . ')';
            case 'array':
                return 'array(' . \count($input) . ')';
            default:
                \ob_start();
                \var_dump($input);
                // normalize float vs double
                /** @var string $varDumpContent */
                $varDumpContent = \ob_get_clean();
                return \str_replace('double(', 'float(', \rtrim($varDumpContent));
        }
    }
    /**
     * Parses an array of header lines into an associative array of headers.
     *
     * @param iterable $lines Header lines array of strings in the following
     *                        format: "Name: Value"
     */
    public static function headersFromLines(iterable $lines) : array
    {
        $headers = [];
        foreach ($lines as $line) {
            $parts = \explode(':', $line, 2);
            $headers[\trim($parts[0])][] = isset($parts[1]) ? \trim($parts[1]) : null;
        }
        return $headers;
    }
    /**
     * Returns a debug stream based on the provided variable.
     *
     * @param mixed $value Optional value
     *
     * @return resource
     */
    public static function debugResource($value = null)
    {
        if (\is_resource($value)) {
            return $value;
        }
        if (\defined('STDOUT')) {
            return \STDOUT;
        }
        return \WPMailSMTP\Vendor\GuzzleHttp\Psr7\Utils::tryFopen('php://output', 'w');
    }
    /**
     * Chooses and creates a default handler to use based on the environment.
     *
     * The returned handler is not wrapped by any default middlewares.
     *
     * @throws \RuntimeException if no viable Handler is available.
     *
     * @return callable(\Psr\Http\Message\RequestInterface, array): \GuzzleHttp\Promise\PromiseInterface Returns the best handler for the given system.
     */
    public static function chooseHandler() : callable
    {
        $handler = null;
        if (\function_exists('curl_multi_exec') && \function_exists('curl_exec')) {
            $handler = \WPMailSMTP\Vendor\GuzzleHttp\Handler\Proxy::wrapSync(new \WPMailSMTP\Vendor\GuzzleHttp\Handler\CurlMultiHandler(), new \WPMailSMTP\Vendor\GuzzleHttp\Handler\CurlHandler());
        } elseif (\function_exists('curl_exec')