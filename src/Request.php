<?php
namespace Jleagle\CurlWrapper;

use Jleagle\CurlWrapper\Exceptions\CurlDisabledException;
use Jleagle\CurlWrapper\Exceptions\CurlException;

class Request
{
  const METHOD_GET = 'get';
  const METHOD_POST = 'post';
  const METHOD_PUT = 'put';
  const METHOD_PATCH = 'patch';
  const METHOD_DELETE = 'delete';

  protected $_options = [];
  protected $_headers = [];

  public function __construct()
  {
    // Check cURL is installed
    if(!function_exists('curl_init'))
    {
      throw new CurlDisabledException('cURL is disabled');
    }

    // Set some default options
    $this->setReturnTransfer();
    $this->setHeadersIn();
    $this->setHeadersOut();

    $userAgent = 'Jleagle\CurlWrapper (https://github.com/Jleagle/curl-wrapper)';
    $this->setUserAgent($userAgent);
  }

  /**
   * @return Request
   */
  public static function i()
  {
    return new static();
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
   * @param int   $option
   * @param mixed $value
   *
   * @return $this
   */
  public function addOption($option, $value)
  {
    $this->_options[$option] = $value;
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
    $this->addOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $this->addOption(CURLOPT_USERPWD, $username . ':' . $password);
    return $this;
  }

  /**
   * @param array $data
   *
   * @return $this
   */
  public function setCookies(array $data)
  {
    $data = http_build_query($data, null, ';');

    $this->addOption(CURLOPT_COOKIE, $data);
    return $this;
  }

  /**
   * @param bool $bool
   *
   * @return $this
   */
  public function setGet($bool = true)
  {
    $this->addOption(CURLOPT_HTTPGET, $bool);
    return $this;
  }

  /**
   * @param bool $bool
   *
   * @return $this
   */
  public function setHeadersIn($bool = true)
  {
    $this->addOption(CURLOPT_HEADER, $bool);
    return $this;
  }

  /**
   * @param bool $bool
   *
   * @return $this
   */
  public function setHeadersOut($bool = true)
  {
    $this->addOption(CURLINFO_HEADER_OUT, $bool);
    return $this;
  }

  /**
   * @param string $method
   *
   * @return $this
   */
  public function setMethod($method)
  {
    $this->addOption(CURLOPT_CUSTOMREQUEST, strtoupper($method));
    return $this;
  }

  /**
   * @param bool $bool
   *
   * @return $this
   */
  public function setPost($bool = true)
  {
    $this->addOption(CURLOPT_POST, $bool);
    return $this;
  }

  /**
   * @param array $data
   *
   * @return $this
   */
  public function setPostFields(array $data)
  {
    if($data)
    {
      $this->addOption(CURLOPT_POSTFIELDS, $data);
    }
    return $this;
  }

  /**
   * @param bool $bool
   *
   * @return $this
   */
  public function setReturnTransfer($bool = true)
  {
    $this->addOption(CURLOPT_RETURNTRANSFER, $bool);
    return $this;
  }

  /**
   * @param int $seconds
   *
   * @return $this
   */
  public function setTimeout($seconds)
  {
    $this->addOption(CURLOPT_TIMEOUT, $seconds);
    return $this;
  }

  /**
   * @param string $userAgent
   *
   * @return $this
   */
  public function setUserAgent($userAgent)
  {
    $this->addOption(CURLOPT_USERAGENT, $userAgent);
    return $this;
  }

  /**
   * @param string $url
   *
   * @return $this
   */
  public function setUrl($url)
  {
    $this->addOption(CURLOPT_URL, $url);
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

    if($output === false || $info === false)
    {
      throw new CurlException('cURL failure');
    }

    $errorNumber = curl_errno($curl);
    $errorMessage = curl_error($curl);

    curl_close($curl);

    return new Response($info, $output, $errorNumber, $errorMessage);
  }
}
