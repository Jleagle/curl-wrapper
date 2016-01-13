<?php
namespace Jleagle\CurlWrapper\Header;

class Cookie
{
  const EXPIRES_FORMAT = 'D, d M y H:i:s \G\M\T';

  protected $name = null;
  protected $value = null;
  protected $domain = null;
  protected $path = '/';
  protected $maxAge = null;
  protected $expires = null;
  protected $secure = false;
  protected $discard = false;
  protected $httpOnly = false;

  /**
   * @return string
   */
  public function toHeader()
  {
    $array = $this->toArray();

    $return = [
      $array['name'] . '=' . $array['value']
    ];

    foreach($array as $k => $v)
    {
      if($k != 'name' && $k != 'value' && $v !== null && $v !== false)
      {
        if($k == 'maxAge')
        {
          $k = 'Max-Age';
        }

        if($k == 'httpOnly')
        {
          $k = 'HttpOnly';
        }

        if($k == 'expires')
        {
          $v = gmdate(self::EXPIRES_FORMAT, strtotime($v));
        }

        $k = ucwords($k);

        $return[] = ($v === true ? $k : $k . '=' . $v);
      }
    }

    return implode('; ', $return);
  }

  /**
   * @param string $cookie
   *
   * @return Cookie
   */
  public static function fromHeader($cookie)
  {
    $return = new Cookie();

    $pieces = array_filter(array_map('trim', explode(';', $cookie)));

    if(!$pieces || !strpos($pieces[0], '='))
    {
      return $return;
    }

    foreach($pieces as $part)
    {
      $cookieParts = explode('=', $part, 2);

      $key = strtolower(trim($cookieParts[0]));

      $value = isset($cookieParts[1])
        ? trim($cookieParts[1], " \n\r\t\0\x0B\"")
        : true;

      switch($key)
      {
        case 'httponly':
          $key = 'httpOnly';
          break;
        case 'max-age':
          $key = 'maxAge';
          break;
        case 'expires':
          $value = gmdate(self::EXPIRES_FORMAT, strtotime($value));
          break;
      }

      $value = urldecode($value);

      if(!$return->name)
      {
        $return->name = $key;
        $return->value = $value;
      }
      else
      {
        $return->$key = $value;
      }
    }

    return $return;
  }

  /**
   * @return string[]
   */
  public function toArray()
  {
    return get_object_vars($this);
  }

  /**
   * @return string
   */
  function __toString()
  {
    return $this->toHeader();
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getValue()
  {
    return $this->value;
  }

  /**
   * @return string|null
   */
  public function getDomain()
  {
    return $this->domain;
  }

  /**
   * @return string
   */
  public function getPath()
  {
    return $this->path;
  }

  /**
   * @return string|null
   */
  public function getMaxAge()
  {
    return $this->maxAge;
  }

  /**
   * @return string|null
   */
  public function getExpires()
  {
    return $this->expires;
  }

  /**
   * @return boolean
   */
  public function isSecure()
  {
    return $this->secure;
  }

  /**
   * @return boolean
   */
  public function isDiscard()
  {
    return $this->discard;
  }

  /**
   * @return boolean
   */
  public function isHttpOnly()
  {
    return $this->httpOnly;
  }
}
