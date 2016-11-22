
<?php
//php 版本7.0.4
//curl 版本 7.47.1
//$cipher = 'TLS_RSA_WITH_AES_256_GCM_SHA384';
define('COOKIE_PATH',getcwd().'/cookies.txt');
class Curl
{
    protected $headers = array();
    protected $ch;
    protected $errno;
    protected $errmsg;
    protected $content;
    protected $info;

    function open($url)
    {
        $this->ch = curl_init($url);
    }

    function close()
    {
        curl_close($this->ch);
    }

    function addHeader($key,$val)
    {
        $this->headers[] = $key.":".$val;
    }

    function setHeaders(array $headers)
    {
        foreach($headers as $k=>$v)
        {
            $this->addHeader($k,$v);
        }
    }

    function getContent()
    {
        return $this->content;
    }

    function getInfo()
    {
        return $this->info;
    }

    function getErrNo()
    {
        return $this->errno;
    }

    function getErrMsg()
    {
        return $this->errmsg;
    }

    function gets()
    {
        $options = array(
            CURLOPT_HEADER         => 1 ,
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => TRUE,    
            CURLOPT_SSL_VERIFYHOST => 2,        // 检查证书中是否设置域名,0不验证
            // CURLOPT_SSL_CIPHER_LIST=> 'TLSv1',
            CURLOPT_CAINFO         => getcwd().'/cacert.pem',
            CURLOPT_COOKIEJAR      => COOKIE_PATH,
        );
        if(!empty($this->headers))
        {
            $options[CULROPT_HTTPHEADER] = $this->headers;
        }

        curl_setopt_array( $this->ch, $options );
        if(!$this->content = curl_exec( $this->ch ))
        {
            $this->err     = curl_errno( $this->ch );
            $this->errmsg  = curl_error( $this->ch );
            return false;
        }
        $this->info  = curl_getinfo( $this->ch );
        return true;
    }

    function posts($data)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => TRUE,    //信任任何证书
            CURLOPT_SSL_VERIFYHOST => 2,        // 检查证书中是否设置域名,0不验证
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $data ,
            CURLOPT_COOKIEFILE     => COOKIE_PATH,
            CURLOPT_CAINFO         => getcwd().'/cacert.pem',
        );

        if(!empty($this->headers))
        {
            $options[CURLOPT_HTTPHEADER] = $this->headers;
        }

        curl_setopt_array( $this->ch, $options );
        if(!$this->content = curl_exec( $this->ch ))
        {
            $this->err     = curl_errno( $this->ch );
            $this->errmsg  = curl_error( $this->ch );
            return false;
        }
        $this->info  = curl_getinfo( $this->ch );
        return true;
    }
}


