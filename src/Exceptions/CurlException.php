<?php
namespace Jleagle\CurlWrapper\Exceptions;

use Jleagle\CurlWrapper\Response;

class CurlException extends \Exception
{
  protected $_response;

  public function setResponse(Response $response)
  {
    $this->_response = $response;
  }

  public function getResponse()
  {
    return $this->_response;
  }
}
