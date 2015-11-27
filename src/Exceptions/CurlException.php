<?php
namespace Jleagle\CurlWrapper\Exceptions;

use Jleagle\CurlWrapper\Response;

class CurlException extends \Exception
{
  /**
   * @var Response|null
   */
  protected $_response;

  /**
   * @param Response $response
   */
  public function setResponse(Response $response)
  {
    $this->_response = $response;
  }

  /**
   * @return Response|null
   */
  public function getResponse()
  {
    return $this->_response;
  }
}
