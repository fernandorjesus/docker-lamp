<?php

namespace WPMailSMTP\Vendor\GuzzleHttp\Exception;

use WPMailSMTP\Vendor\Psr\Http\Client\NetworkExceptionInterface;
use WPMailSMTP\Vendor\Psr\Http\Message\RequestInterface;
/**
 * Exception thrown when a connection cannot be established.
 *
 * Note that no response is present for a ConnectException
 */
class ConnectException extends \WPMailSMTP\Vendor\GuzzleHttp\Exception\TransferException implements \WPMailSMTP\Vendor\Psr\Http\Client\NetworkExceptionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var array
     */
    private $handlerContext;
    public function __construct(string $message, \WPMailSMTP\Vendor\Psr\Http\Message\RequestInterface $request, \Throwable $previous = null, array $handlerContext = [])
    {
        parent::__constr