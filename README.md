curl-wrapper
============

#### Using the helper

```php
$response = Curl::get(URL)->run();
$response = Curl::get(URL, ['k' => 'v'])->run();
```

#### Manually making a cURL request

```php
$response = Request::i()
  ->setUrl(URL)
  ->setPost()
  ->setBasicAuth('username', 'password')
  ->setPostFields(['k' => 'v'])
  ->run();
```

#### Reading the response
```php
$response = Curl::get(URL)->run();

$connectTime = $response->getConnectTime();
$httpCode = $response->getHttpCode();
$error = $response->getErrorMessage();
```
