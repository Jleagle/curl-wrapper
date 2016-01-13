<?php
namespace Jleagle\CurlWrapper\Header;

use Packaged\Helpers\Objects;

class CookieJar
{
  /**
   * @var Cookie[]
   */
  protected $_cookies = [];

  /**
   * @return Cookie[]
   */
  public function getCookies()
  {
    return $this->_cookies;
  }

  /**
   * @param Cookie $cookie
   */
  public function addCookie(Cookie $cookie)
  {
    $name = $cookie->getName();
    $this->_cookies[$name] = $cookie;
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return http_build_query($this->getValues(), null, '; ');
  }

  /**
   * @return string[]
   */
  public function toArray()
  {
    return Objects::mpull($this->getCookies(), 'toArray');
  }

  /**
   * @return string[]
   */
  public function getValues()
  {
    return Objects::mpull($this->getCookies(), 'getValue', 'getName');
  }
}
