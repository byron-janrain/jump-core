<?php
namespace janrain\jump;

class CaptureApi
{
    protected $conf;

    protected $ctx;
    protected $data;

    public function __construct(CaptureApiConfig $conf) {
        $this->conf = $conf;
        $this->data = array();
        $this->ctx = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Accept-Encoding: identity\r\nContent-type: application/x-www-form-urlencoded\r\n",
                ));
        $this->url = $opts['capture.captureServer'];
        if ($this->url[(strlen($this->url) - 1)] !== '/') {
            $this->url .= '/';
        }
    }

    /**
     * Make a call against
     */
    public function __invoke($url, $params) {
        $params = array_merge($this->data, $params);
        if (!empty($params['token'])) {
            unset($params['client_id']);
            unset($params['client_secret']);
            $this->ctx['http']['header'] .= "Authorization: OAuth {$params['token']}\r\n";
            unset($params['token']);
        }
        $this->ctx['http']['content'] = http_build_query($params);
        $stream = stream_context_create($this->ctx);
        $resp = json_decode(file_get_contents($this->url . $url, false, $stream), true);
        if (empty($resp['stat']) || $resp['stat'] == 'error') {
            throw new \Exception($resp['error_description']);
        }
        return $resp['result'];
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
