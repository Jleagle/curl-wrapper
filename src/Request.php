<?php
namespace Jleagle\CurlWrapper;

use Jleagle\CurlWrapper\Exceptions\CurlDisabledException;
use Jleagle\CurlWrapper\Exceptions\CurlException;
use Jleagle\CurlWrapper\Header\Cookie;
use Jleagle\CurlWrapper\Header\CookieJar;

class Request
{
  const AGENT_AGENT = 'Jleagle\CurlWrapper (https://github.com/Jleagle/curl-wrapper)';

  /**
   * @var string[]
   */
  protected $_options = [];

  /**
   * @var string[]
   */
  protected $_headers = [];

  /**
   * @var string[]
   */
  protected $_returnHeaders = [];

  /**
   * @var CookieJar
   */
  protected $_cookies;

  /**
   * Request constructor.
   */
  public function __construct()
  {
    // Check cURL is installed
    if(!function_exists('curl_init'))
    {
      throw new CurlDisabledException('cURL is disabled');
    }

    // Set some default options
    $this->setReturnTransfer();
    $this->setFollowRedirects();
    $this->setHeadersOut();
    $this->setHeaderCallback([$this, '_headerCallback']);
    $this->setUserAgent(self::AGENT_AGENT);
  }

  /**
   * @return Request
   */
  public static function i()
  {
    return new static();
  }

  /**
   * @param        $curlHandle
   * @param string $headerLine
   *
   * @return int
   */
  protected function _headerCallback($curlHandle, $headerLine)
  {
    $this->_returnHeaders[] = $headerLine;
    return strlen($headerLine);
  }

  /**
   * @param string $header
   * @param string $value
   *
   * @return $this
   */
  public function addHeader($header, $value)
  {
    $this->_headers[$header] = $header . ': ' . $value;
    return $this;
  }

  /**
   * @param string $key
   *
   * @return bool
   */
  public function hasHeader($key)
  {
    return isset($this->_headers[$key]);
  }

  /**
   * @param int   $option
   * @param mixed $value
   *
   * @return $this
   */
  public function setOption($option, $value)
  {
    $this->_options[$option] = $value;
    return $this;
  }

  /**
   * @param int $option
   *
   * @return bool
   */
  public function hasOption($option)
  {
    return isset($this->_options[$option]);
  }

  /**
   * @param string $username
   * @param string $password
   *
   * @return $this
   */
  public function setBasicAuth($username, $password)
  {
    $this->setOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $this->setOption(CURLOPT_USERPWD, $username . ':' . $password);
    return $this;
  }

  /**
   * @param CookieJar $cookieJar
   *
   * @return $this
   */
  public function setCookies(CookieJar $cookieJar)
  {
    $this->_cookies = $cookieJar;
    return $this;
  }

  /**
   * @param Cookie $cookie
   *
   * @return $this
   */
  public function addCookie(Cookie $cookie)
  {
    $this->_cookies->addCookie($cookie);
    return $this;
  }

  /**
   * @param $contentType - ContentTypeEnum
   *
   * @return $this
   */
  public function setContentType($contentType)
  {
    $this->addHeader('Content-Type', $contentType);
    return $this;
  }

  /**
   * Ask for a HTTP GET request
   *
   * @param bool $bool
   *
   * @return $this
   */
  public function setGet($bool = true)
  {
    $this->setOption(CURLOPT_HTTPGET, $bool);
    return $this;
  }

  /**
   * Follow HTTP 3xx redirects
   *
   * @param bool $bool
   * @param bool $enableCookieEngine
   *
   * @return $this
   */
  public function setFollowRedirects($bool = true, $enableCookieEngine = true)
  {
    $this->setOption(CURLOPT_FOLLOWLOCATION, $bool);

    if($enableCookieEngine)
    {
      $this->setCookieFile();
    }

    return $this;
  }

  /**
   * Pass headers to the data stream
   *
   * @param bool $bool
   *
   * @return $this
   */
  public function setHeadersIn($bool = true)
  {
    $this->setOption(CURLOPT_HEADER, $bool);
    return $this;
  }

  /**
   * @param string $filePath
   *
   * @return $this
   */
  public function setCookieFile($filePath = '')
  {
    $this->setOption(CURLOPT_COOKIEFILE, $filePath);
    return $this;
  }

  /**
   * @param string $referer
   *
   * @return $this
   */
  public function setReferer($referer)
  {
    $this->setOption(CURLOPT_REFERER, $referer);
    return $this;
  }

  /**
   * @param $callable
   *
   * @return $this
   */
  public function setHeaderCallback($callable)
  {
    $this->setOption(CURLOPT_HEADERFUNCTION, $callable);
    return $this;
  }

  /**
   * @param bool $bool
   *
   * @return $this
   */
  public function setVerbose($bool = true)
  {
    $this->setOption(CURLOPT_VERBOSE, $bool);
    return $this;
  }

  /**
   * @param bool $bool
   *
   * @return $this
   */
  public function setHeadersOut($bool = true)
  {
    $this->setOption(CURLINFO_HEADER_OUT, $bool);
    return $this;
  }

  /**
   * Custom string for request
   *
   * @param string $method
   *
   * @return $this
   */
  public function setMethod($method)
  {
    $this->setOption(CURLOPT_CUSTOMREQUEST, strtoupper($method));
    return $this;
  }

  /**
   * Request a HTTP POST
   *
   * @param bool $bool
   *
   * @return $this
   */
  public function setPost($bool = true)
  {
    $this->setOption(CURLOPT_POST, $bool);
    return $this;
  }

  /**
   * Specify data to POST to server
   *
   * @param array|string $data
   *
   * @return $this
   */
  public function setPostFields($data)
  {
    if($data)
    {
      if(is_array($data))
      {
        $data = http_build_query($data);
      }
      $this->setOption(CURLOPT_POSTFIELDS, $data);
    }
    return $this;
  }

  /**
   * Return the raw output
   *
   * @param bool $bool
   *
   * @return $this
   */
  public function setReturnTransfer($bool = true)
  {
    $this->setOption(CURLOPT_RETURNTRANSFER, $bool);
    return $this;
  }

  /**
   * Set maximum time the request is allowed to take
   *
   * @param int $seconds
   *
   * @return $this
   */
  public function setTimeout($seconds)
  {
    $this->setOption(CURLOPT_TIMEOUT, $seconds);
    return $this;
  }

  /**
   * Set HTTP user-agent header
   *
   * @param string $userAgent
   *
   * @return $this
   */
  public function setUserAgent($userAgent)
  {
    $this->setOption(CURLOPT_USERAGENT, $userAgent);
    return $this;
  }

  /**
   * Provide the URL to use in the request
   *
   * @param string $url
   *
   * @return $this
   */
  public function setUrl($url)
  {
    $this->setOption(CURLOPT_URL, $url);
    return $this;
  }

  /**
   * @return resource
   */
  public function getCurlResource()
  {
    $curl = curl_init();

    curl_setopt_array($curl, $this->_options);

    if($this->_headers)
    {
      curl_setopt($curl, CURLOPT_HTTPHEADER, array_values($this->_headers));
    }

    if($this->_cookies)
    {
      curl_setopt($curl, CURLOPT_COOKIE, (string)$this->_cookies);
    }

    return $curl;
  }

  /**
   * @return Response
   *
   * @throws CurlException
   */
  public function run()
  {
    $curl = $this->getCurlResource();

    $output = curl_exec($curl);
    $info = curl_getinfo($curl);
    $errorNumber = curl_errno($curl);
    $errorMessage = curl_error($curl);

    curl_close($curl);

    $response = new Response(
      $output,
      $info,
      $errorNumber,
      $errorMessage,
      $this->_returnHeaders
    );

    if($output === false || $info === false)
    {
      $exception = new CurlException('cURL failure');
      $exception->setResponse($response);
      throw $exception;
    }

    return $response;
  }
}
