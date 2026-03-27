<?php

namespace WPMailSMTP\Vendor\GuzzleHttp\Cookie;

/**
 * Set-Cookie object
 */
class SetCookie
{
    /**
     * @var array
     */
    private static $defaults = ['Name' => null, 'Value' => null, 'Domain' => null, 'Path' => '/', 'Max-Age' => null, 'Expires' => null, 'Secure' => \false, 'Discard' => \false, 'HttpOnly' => \false];
    /**
     * @var array Cookie data
     */
    private $data;
    /**
     * Create a new SetCookie object from a string.
     *
     * @param string $cookie Set-Cookie header string
     */
    public static function fromString(string $cookie) : self
    {
        // Create the default return array
        $data = self::$defaults;
        // Explode the cookie string using a series of semicolons
        $pieces = \array_filter(\array_map('trim', \explode(';', $cookie)));
        // The name of the cookie (first kvp) must exist and include an equal sign.
        if (!isset($pieces[0]) || \strpos($pieces[0], '=') === \false) {
            return new self($data);
        }
        // Add the cookie pieces into the parsed data array
        foreach ($pieces as $part) {
            $cookieParts = \explode('=', $part, 2);
            $key = \trim($cookieParts[0]);
            $value = isset($cookieParts[1]) ? \trim($cookieParts[1], " \n\r\t\0\v") : \true;
            // Only check for non-cookies when cookies have been found
            if (!isset($data['Name'])) {
                $data['Name'] = $key;
                $data['Value'] = $value;
            } else {
                foreach (\array_keys(self::$defaults) as $search) {
                    if (!\strcasecmp($search, $key)) {
                        $data[$search] = $value;
                        continue 2;
                    }
                }
                $data[$key] = $value;
            }
        }
        return new self($data);
    }
    /**
     * @param array $data Array of cookie data provided by a Cookie parser
     */
    public function __construct(array $data = [])
    {
        /** @var array|null $replaced will be null in case of replace error */
        $replaced = \array_replace(self::$defaults, $data);
        if ($replaced === null) {
            throw new \InvalidArgumentException('Unable to replace the default values for the Cookie.');
        }
        $this->data = $replaced;
        // Extract the Expires value and turn it into a UNIX timestamp if needed
        if (!$this->getExpires() && $this->getMaxAge()) {
            // Calculate the Expires date
            $this->setExpires(\time() + $this->getMaxAge());
        } elseif (null !== ($expires = $this->getExpires()) && !\is_numeric($expires)) {
            $this->setExpires($expires);
        }
    }
    public function __toString()
    {
        $str = $this->data['Name'] . '=' . ($this->data['Value'] ?? '') . '; ';
        foreach ($this->data as $k => $v) {
            if ($k !== 'Name' && $k !== 'Value' && $v !== null && $v !== \false) {
                if ($k === 'Expires') {
                    $str .= 'Expires=' . \gmdate('D, d M Y H:i:s \\G\\M\\T', $v) . '; ';
                } else {
                    $str .= ($v === \true ? $k : "{$k}={$v}") . '; ';
                }
            }
        }
        return \rtrim($str, '; ');
    }
    public function toArray() : array
    {
        return $this->data;
    }
    /**
     * Get the cookie name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->data['Name'];
    }
    /**
     * Set the cookie name.
     *
     * @param string $name Cookie name
     */
    public function setName($name) : void
    {
        if (!\is_string($name)) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing a string to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Name'] = (string) $name;
    }
    /**
     * Get the cookie value.
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->data['Value'];
    }
    /**
     * Set the cookie value.
     *
     * @param string $value Cookie value
     */
    public function setValue($value) : void
    {
        if (!\is_string($value)) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing a string to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Value'] = (string) $value;
    }
    /**
     * Get the domain.
     *
     * @return string|null
     */
    public function getDomain()
    {
        return $this->data['Domain'];
    }
    /**
     * Set the domain of the cookie.
     *
     * @param string|null $domain
     */
    public function setDomain($domain) : void
    {
        if (!\is_string($domain) && null !== $domain) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing a string or null to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Domain'] = null === $domain ? null : (string) $domain;
    }
    /**
     * Get the path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->data['Path'];
    }
    /**
     * Set the path of the cookie.
     *
     * @param string $path Path of the cookie
     */
    public function setPath($path) : void
    {
        if (!\is_string($path)) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing a string to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Path'] = (string) $path;
    }
    /**
     * Maximum lifetime of the cookie in seconds.
     *
     * @return int|null
     */
    public function getMaxAge()
    {
        return null === $this->data['Max-Age'] ? null : (int) $this->data['Max-Age'];
    }
    /**
     * Set the max-age of the cookie.
     *
     * @param int|null $maxAge Max age of the cookie in seconds
     */
    public function setMaxAge($maxAge) : void
    {
        if (!\is_int($maxAge) && null !== $maxAge) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing an int or null to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Max-Age'] = $maxAge === null ? null : (int) $maxAge;
    }
    /**
     * The UNIX timestamp when the cookie Expires.
     *
     * @return string|int|null
     */
    public function getExpires()
    {
        return $this->data['Expires'];
    }
    /**
     * Set the unix timestamp for which the cookie will expire.
     *
     * @param int|string|null $timestamp Unix timestamp or any English textual datetime description.
     */
    public function setExpires($timestamp) : void
    {
        if (!\is_int($timestamp) && !\is_string($timestamp) && null !== $timestamp) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing an int, string or null to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Expires'] = null === $timestamp ? null : (\is_numeric($timestamp) ? (int) $timestamp : \strtotime((string) $timestamp));
    }
    /**
     * Get whether or not this is a secure cookie.
     *
     * @return bool
     */
    public function getSecure()
    {
        return $this->data['Secure'];
    }
    /**
     * Set whether or not the cookie is secure.
     *
     * @param bool $secure Set to true or false if secure
     */
    public function setSecure($secure) : void
    {
        if (!\is_bool($secure)) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing a bool to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Secure'] = (bool) $secure;
    }
    /**
     * Get whether or not this is a session cookie.
     *
     * @return bool|null
     */
    public function getDiscard()
    {
        return $this->data['Discard'];
    }
    /**
     * Set whether or not this is a session cookie.
     *
     * @param bool $discard Set to true or false if this is a session cookie
     */
    public function setDiscard($discard) : void
    {
        if (!\is_bool($discard)) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing a bool to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['Discard'] = (bool) $discard;
    }
    /**
     * Get whether or not this is an HTTP only cookie.
     *
     * @return bool
     */
    public function getHttpOnly()
    {
        return $this->data['HttpOnly'];
    }
    /**
     * Set whether or not this is an HTTP only cookie.
     *
     * @param bool $httpOnly Set to true or false if this is HTTP only
     */
    public function setHttpOnly($httpOnly) : void
    {
        if (!\is_bool($httpOnly)) {
            trigger_deprecation('guzzlehttp/guzzle', '7.4', 'Not passing a bool to %s::%s() is deprecated and will cause an error in 8.0.', __CLASS__, __FUNCTION__);
        }
        $this->data['HttpOnly'] = (bool) $httpOnly;
    }
    /**
     * Check if the cookie matches a path value.
     *
     * A request-path path-matches a given cookie-path if at least one of
     * the following conditions holds:
     *
     * - The cookie-path and the request-path are identical.
     * - The cookie-path is a prefix of the request-path, and the last
     *   character of the cookie-path is %x2F ("/").
     * - The cookie-path is a prefix of the request-path, and the first
     *   character of the request-path that is not included in the cookie-
     *   path is a %x2F ("/") character.
     *
     * @param string $requestPath Path to check against
     */
    public function matchesPath(string $requestPath) : bool
    {
        $cookiePath = $this->getPath();
        // Match on exact matches or when path is the default empty "/"
        if ($cookiePath === '/' || $cookiePath == $requestPath) {
            return \true;
        }
        // Ensure that the cookie-path is a prefix of the request path.
        if (0 !== \strpos($requestPath, $cookiePath)) {
            return \false;
        }
        // Match if the last character of the cookie-path is "/"
        if (\substr($cookiePath, -1, 1) === '/') {
            return \true;
        }
        // Mat