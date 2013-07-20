<?php
namespace janrain\jump;

class CaptureApi
{
    protected $conf;

    protected $ctx;
    protected $data;
    protected $url;

    public function __construct(CaptureApiConfig $conf) {
        $this->conf = $conf;
        $this->data = array();
        $this->ctx = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Accept-Encoding: identity\r\nContent-type: application/x-www-form-urlencoded\r\n",
                ));
        $this->url = $this->conf['capture.captureServer'];
        if ($this->url[(strlen($this->url) - 1)] !== '/') {
            $this->url .= '/';
        }
    }

    /**
     * Make a call against
     */
    public function __invoke($url, $params, $token = null) {
        $params = array_merge($this->data, $params);
        if ($token) {
            $this->ctx['http']['header'] .= "Authorization: OAuth {$token}\r\n";
        } else {
            $this->signCtx();
        }
        $this->ctx['http']['content'] = http_build_query($params);
        $stream = stream_context_create($this->ctx);
        $resp = json_decode(file_get_contents($this->url . $url, false, $stream), true);
        if (empty($resp['stat']) || $resp['stat'] == 'error') {
            throw new \Exception($resp['error_description']);
        }
        return $resp['result'];
    }

    private function signRequest($params, $url)
    {
        #no token found, use message signing so we never transfer the client_secret
        $timeStr = gmdate('Y-m-d H:i:s');
        $this->ctx['http']['header'] .= "Date: {$timeStr}\r\n";
        $data = "{$url}\n{$timeStr}\n";
        foreach ($params as $k => $v) {
            $data .= "{$k}={$v}\n";
        }
        $rawDigest = hash_hmac('sha1', $data, $this->conf['capture.clientSecret'], true);
        $b64 = base64_encode($rawDigest);
        $this->ctx['http']['header'] .= "Authorization: Signature {$this->conf['capture.clientId']}:{$b64}\r\n";
    }


    /**
     * Retreive a JUMP User from capture using the provided token.
     */
    public function fetchUserByUuid($uuid, $token = null)
    {
        $data = $this('entity', array('uuid' => $uuid, 'token' => $token, 'type_name'=>'user'));
        $user = User::__set_state($data);
        return $user;
    }

    public static function generateUuid()
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes(16);
            $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
            $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);
            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
        }
        if (empty($uuid) && (false === strpos(ini_get('disabled_functions', 'shell_exec')))) {
            $uuid = `uuidgen`;
        }
        if (empty($uuid)) {
            throw new \Exception();
        }
        return $uuid;
    }
}
