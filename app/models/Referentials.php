<?php

/*
|--------------------------------------------------------------------------
| Author            : DuRenK
| Created_at        : 14/06/2015
|--------------------------------------------------------------------------
*/

class Referentials {

  protected static $codes = array(
    100 => "Continue",
    101 => "Switching Protocols",
    102 => "Processing",
    200 => "OK",
    201 => "Created",
    202 => "Accepted",
    203 => "Non-Authoritative Information",
    204 => "No Content",
    205 => "Reset Content",
    206 => "Partial Content",
    207 => "Multi-Status",
    208 => "Already Reported",
    226 => "IM Used",
    300 => "Multiple Choices",
    301 => "Moved Permanently",
    302 => "Found",
    303 => "See Other",
    304 => "Not Modified",
    305 => "Use Proxy",
    306 => "Switch Proxy",
    307 => "Temporary Redirect",
    308 => "Permanent Redirect",
    400 => "Bad Request",
    401 => "Unauthorized",
    402 => "Payment Required",
    403 => "Forbidden",
    404 => "Not Found",
    405 => "Method Not Allowed",
    406 => "Not Acceptable",
    407 => "Proxy Authentication Required",
    408 => "Request Timeout",
    409 => "Conflict",
    410 => "Gone",
    411 => "Length Required",
    412 => "Precondition Failed",
    413 => "Request Entity Too Large",
    414 => "Request-URI Too Long",
    415 => "Unsupported Media Type",
    416 => "Requested Range Not Satisfiable",
    417 => "Expectation Failed",
    418 => "I'm a teapot",
    420 => "Enhance Your Calm",
    422 => "Unprocessable Entity",
    423 => "Locked",
    424 => "Failed Dependency",
    425 => "Unordered Collection",
    426 => "Upgrade Required",
    428 => "Precondition Required",
    429 => "Too Many Requests",
    431 => "Request Header Fields Too Large",
    444 => "No Response",
    449 => "Retry With",
    450 => "Blocked by Windows Parental Controls",
    499 => "Client Closed Request",
    500 => "Internal Server Error",
    501 => "Not Implemented",
    502 => "Bad Gateway",
    503 => "Service Unavailable",
    504 => "Gateway Timeout",
    505 => "HTTP Version Not Supported",
    506 => "Variant Also Negotiates",
    507 => "Insufficient Storage",
    509 => "Bandwidth Limit Exceeded",
    510 => "Not Extended"
  );

  protected static $charsets = array(
    "UTF-8", "ISO-8859-1", "UTF-16"
  );

  protected static $contentTypes = array(
    "application/json" => "json",
    "application/xml" => "xml",
    "application/xhtml+xml" => "html",
    "text/plain" => "text",
    "text/html" => "html",
    "text/xml" => "xml",
    "text/json" => "json",
    "text/css" => "css",
    "text/csv" => "text",
    "application/x-www-form-urlencoded" => "text",
    "multipart/form-data" => "text"
  );

  public static function mappingIdName($var) {

    $dataArray = array();
    ksort(self::$$var);
    foreach (self::$$var as $key => $value) {
        switch ($var) {
            case 'codes':
                $value = "$key $value";
                break;
            case 'charsets':
                $key = $value;
                break;
            case 'contentTypes':
                $value = $key;
                break;
        }
        $dataArray[] = "{ id: ".json_encode($key).", text: ".json_encode($value)." }";
    }
    return "[" . implode(", ", $dataArray) . "]";

  }

}
