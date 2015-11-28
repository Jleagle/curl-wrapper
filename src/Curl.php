<?php
namespace Jleagle\CurlWrapper;

use Jleagle\CurlWrapper\Enums\MethodTypeEnum;

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
  public static function post($url, $data = [])
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
      ->setMethod(MethodTypeEnum::PUT);
  }

  /**
   * @param string $url
   * @param array  $data
   *
   * @return Request
   */
  public static function patch($url, $data = [])
  {
    $curl = Request::i()
      ->setUrl($url)
      ->setMethod(MethodTypeEnum::PATCH)
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
      ->setMethod(MethodTypeEnum::DELETE);
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
