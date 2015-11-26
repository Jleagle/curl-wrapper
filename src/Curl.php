<?php
namespace Jleagle\CurlWrapper;

class Curl
{
  /**
   * @param string $url
   * @param array  $data
   *
   * @return Request
   */
  public static function get($url, array $data = [])
  {
    $url = static::_makeUrl($url, $data);

    return Request::i()
      ->setUrl($url)
      ->setGet();
  }

  /**
   * @param string $url
   * @param array  $data
   *
   * @return Request
   */
  public static function post($url, array $data = [])
  {
    $curl = Request::i()
      ->setUrl($url)
      ->setPost()
      ->setPostFields($data);

    return $curl;
  }

  /**
   * @param string $url
   * @param array  $data
   *
   * @return Request
   */
  public static function put($url, array $data = [])
  {
    $url = static::_makeUrl($url, $data);

    return Request::i()
      ->setUrl($url)
      ->setMethod(Request::METHOD_PUT);
  }

  /**
   * @param string $url
   * @param array  $data
   *
   * @return Request
   */
  public static function patch($url, array $data = [])
  {
    $curl = Request::i()
      ->setUrl($url)
      ->setMethod(Request::METHOD_PATCH)
      ->setPostFields($data);

    return $curl;
  }

  /**
   * @param string $url
   * @param array  $data
   *
   * @return Request
   */
  public static function delete($url, array $data = [])
  {
    $url = static::_makeUrl($url, $data);

    return Request::i()
      ->setUrl($url)
      ->setMethod(Request::METHOD_DELETE);
  }

  /**
   * @param string $url
   * @param array  $data
   *
   * @return string
   */
  protected static function _makeUrl($url, array $data = [])
  {
    if($data)
    {
      $data = http_build_query($data);
      $separator = (parse_url($url, PHP_URL_QUERY) == null) ? '?' : '&';
      return $url . $separator . $data;
    }
    return $url;
  }
}