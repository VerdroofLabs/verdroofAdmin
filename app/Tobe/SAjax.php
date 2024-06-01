<?php
/**
 * Class SAjax (Server Ajax)
 * this class implements cUrl to send server  to server requests
 *
 * @author Tobechukwu Onuigbo => Tobey14
 * @copyright Since 18th July 2021
 * @version 1.0
 * @since 5.6
 * @updated 18th July 2021
 */

namespace App\Tobe;

class SAjax
{
    private array $responseHeaders;

    //curl_setopt( $ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip")); Change IP
    private string $userAgent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36";
    /**
     * @param string $userAgent
     * @return SAjax
     */
    public function setUserAgent(string $userAgent): SAjax
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    private array $headers = [
        "X-Requested-With: XMLHttpRequest",
    ];
    /**
     * @param array|string $header
     * @return SAjax
     */
    public function setHeaders(array|string $header): SAjax
    {
        if (is_array($header)) {
            $this->headers = array_merge($this->headers, $header);
            return $this;
        }
        $this->headers[] = $header;
        return $this;
    }

    private array $files = [];
    /**
     * @param array $files
     * @return SAjax
     */
    public function setFiles(array $files): SAjax
    {
        $this->files = $files;
        return $this;
    }

    private function curlInit($url): \CurlHandle|bool
    {
        $h = explode('/', $url);
        $r = [];
        for ($i = 0; $i < 3; $i++) {
            $r[] = $h[$i];
        }
        $referer = implode('/', $r);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        // this function is called by curl for each header received
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                {
                    return $len;
                }

                $this->responseHeaders[strtolower(trim($header[0]))] = trim($header[1]);

                return $len;
            }
        );
//        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieLocation);
//        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieLocation);


        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        return $ch;
    }

    public function get($url, array $data = []): SAjaxResponse
    {
        $queryParams = $data ? http_build_query($data) : "";
        $url .= preg_match('/(\?)/', $url) ? "&" . $queryParams : "?" . $queryParams;

        $ch = $this->curlInit($url);

        $response =  curl_exec($ch);
        $err = curl_error($ch);
        if ($err) {
            throw new \RuntimeException($err);
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return new SAjaxResponse($response, $this->responseHeaders, $httpCode);
    }

    public function post($url, $data, $jsonBody = false): string
    {
        if ($jsonBody){
            $this->setHeaders("Content-Type: application/json; charset=utf-8");
        }

        $ch = $this->curlInit($url);

        if ($this->files) {
            foreach ($this->files as $fieldName => $file) {
                if (function_exists('curl_file_create')) { // php 5.5+
                    $cFile = curl_file_create($file);
                } else { //
                    $cFile = '@' . realpath($file);
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                }
                $data[$fieldName] = $cFile;
            }
        }
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody ? json_encode($data) : http_build_query($data));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        if ($err) {
            throw new \RuntimeException($err);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        return $response;

        // return new SAjaxResponse($response, $this->responseHeaders, $httpCode)->getResponse();
    }
}


class SAjaxResponse
{
    public function __construct($response, $headers, $httpCode)
    {
        $this->setResponse($response);
        $this->setHeaders($headers);
        $this->setHttpCode($httpCode);
    }

    private string $response;

    private array $headers;

    private int $httpCode;

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @param string $response
     */
    private function setResponse(string $response): void
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    private function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @param $httpCode
     */
    private function setHttpCode($httpCode): void
    {
        $this->httpCode = $httpCode;
    }

    /**
     *
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
