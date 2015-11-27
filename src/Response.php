<?php
namespace Jleagle\CurlWrapper;

use Jleagle\CurlWrapper\Exceptions\CurlInvalidJsonException;
use Packaged\Helpers\Arrays;

class Response
{
  protected $_output;
  protected $_info;
  protected $_errorNumber;
  protected $_errorMessage;

  /**
   * Response constructor.
   *
   * @param string $output
   * @param array  $info
   * @param int    $errorNumber
   * @param string $errorMessage
   */
  public function __construct($output, array $info, $errorNumber, $errorMessage)
  {
    $this->_output = $output;
    $this->_info = $info;
    $this->_errorNumber = $errorNumber;
    $this->_errorMessage = $errorMessage;
  }

  /**
   * @return array
   *
   * @throws CurlInvalidJsonException
   */
  public function getJson()
  {
    $json = json_decode($this->getOutput(), true);

    if(json_last_error() == JSON_ERROR_NONE)
    {
      return $json;
    }

    throw new CurlInvalidJsonException();
  }

  /**
   * @return string
   */
  public function getOutput()
  {
    return $this->_output;
  }

  /**
   * @return int
   */
  public function getErrorNumber()
  {
    return $this->_errorNumber;
  }

  /**
   * @return string
   */
  public function getErrorMessage()
  {
    return $this->_errorMessage;
  }

  /**
   * @return string
   */
  public function getUrl()
  {
    return Arrays::value($this->_info, 'url');
  }

  /**
   * @return string
   */
  public function getContentType()
  {
    return Arrays::value($this->_info, 'content_type');
  }

  /**
   * @return int
   */
  public function getHttpCode()
  {
    return Arrays::value($this->_info, 'http_code');
  }

  /**
   * @return int
   */
  public function getHeaderSize()
  {
    return Arrays::value($this->_info, 'header_size');
  }

  /**
   * @return int
   */
  public function getRequestSize()
  {
    return Arrays::value($this->_info, 'request_size');
  }

  /**
   * @return int
   */
  public function getFiletime()
  {
    return Arrays::value($this->_info, 'filetime');
  }

  /**
   * @return int
   */
  public function getSslVerifyResult()
  {
    return Arrays::value($this->_info, 'ssl_verify_result');
  }

  /**
   * @return int
   */
  public function getRedirectCount()
  {
    return Arrays::value($this->_info, 'redirect_count');
  }

  /**
   * @return float
   */
  public function getTotalTime()
  {
    return Arrays::value($this->_info, 'total_time');
  }

  /**
   * @return float
   */
  public function getNamelookupTime()
  {
    return Arrays::value($this->_info, 'namelookup_time');
  }

  /**
   * @return float
   */
  public function getConnectTime()
  {
    return Arrays::value($this->_info, 'connect_time');
  }

  /**
   * @return float
   */
  public function getPretransferTime()
  {
    return Arrays::value($this->_info, 'pretransfer_time');
  }

  /**
   * @return int
   */
  public function getSizeUpload()
  {
    return Arrays::value($this->_info, 'size_upload');
  }

  /**
   * @return int
   */
  public function getSizeDownload()
  {
    return Arrays::value($this->_info, 'size_download');
  }

  /**
   * @return int
   */
  public function getSpeedDownload()
  {
    return Arrays::value($this->_info, 'speed_download');
  }

  /**
   * @return int
   */
  public function getSpeedUpload()
  {
    return Arrays::value($this->_info, 'speed_upload');
  }

  /**
   * @return int
   */
  public function getDownloadContentLength()
  {
    return Arrays::value($this->_info, 'download_content_length');
  }

  /**
   * @return int
   */
  public function getUploadContentLength()
  {
    return Arrays::value($this->_info, 'upload_content_length');
  }

  /**
   * @return float
   */
  public function getStarttransferTime()
  {
    return Arrays::value($this->_info, 'starttransfer_time');
  }

  /**
   * @return int
   */
  public function getRedirectTime()
  {
    return Arrays::value($this->_info, 'redirect_time');
  }

  /**
   * @return array
   */
  public function getCertinfo()
  {
    return Arrays::value($this->_info, 'certinfo', []);
  }

  /**
   * @return string
   */
  public function getPrimaryIp()
  {
    return Arrays::value($this->_info, 'primary_ip');
  }

  /**
   * @return int
   */
  public function getPrimaryPort()
  {
    return Arrays::value($this->_info, 'primary_port');
  }

  /**
   * @return string
   */
  public function getLocalIp()
  {
    return Arrays::value($this->_info, 'local_ip');
  }

  /**
   * @return int
   */
  public function getLocalPort()
  {
    return Arrays::value($this->_info, 'local_port');
  }

  /**
   * @return string
   */
  public function getRedirectUrl()
  {
    return Arrays::value($this->_info, 'redirect_url');
  }

  /**
   * @return string
   */
  public function getRequestHeader()
  {
    return Arrays::value($this->_info, 'request_header');
  }
}
