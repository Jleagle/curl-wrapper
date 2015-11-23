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
    if($data)
    {
      $url = $url . '?' . http_build_query($data);
    }

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
      ->setPost();

    if($data)
    {
      $curl->setPostFields($data);
    }

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
    if($data)
    {
      $url = $url . '?' . http_build_query($data);
    }

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
      ->setMethod(Request::METHOD_PATCH);

    if($data)
    {
      $curl->setPostFields($data);
    }

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
    if($data)
    {
      $url = $url . '?' . http_build_query($data);
    }

    return Request::i()
      ->setUrl($url)
      ->setMethod(Request::METHOD_DELETE);
  }
}
