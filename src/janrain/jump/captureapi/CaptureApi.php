<?php
namespace janrain\jump\captureapi;

use janrain\jump\AbstractFeature;
use janrain\jump\User;

class CaptureApi extends AbstractFeature
{
    protected $conf;
    protected $ctx;
    protected $url;
    protected $reqHeaders;

    public function __construct(CaptureApiConfig $conf) {
        $this->conf = $conf;
        $this->reqHeaders = array();
        $this->ctx = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Accept-Encoding: identity\r\n" . "Content-type: application/x-www-form-urlencoded\r\n"
                ));
        $this->url = $this->conf['capture.captureServer'];
        if ($this->url[(strlen($this->url) - 1)] !== '/') {
            $this->url .= '/';
        }
    }

    /**
     * Make a call against
     */
    public function __invoke($endpoint, $params, $token = null) {
        if ($token) {
            $this->reqHeaders[] = "Authorization: OAuth {$token}";
        } else {
            $this->signRequest($endpoint, $params);
        }
        #copy the array;
        $ctx = $this->ctx;
        $ctx['http']['content'] = http_build_query($params);
        $ctx['http']['header'] .= implode("\r\n", $this->reqHeaders) . "\r\n";
        $stream = stream_context_create($ctx);
        $rawResp = file_get_contents($this->url . $endpoint, false, $stream);
        $resp = json_decode($rawResp, true);
        if (empty($resp['stat']) || $resp['stat'] == 'error') {
            throw new \Exception($resp['error_description']);
        }
        $this->reqHeaders = array();
        return isset($resp['result']) ? $resp['result'] : $resp;
    }

    private function signRequest($url, &$params)
    {
        #no token found, use message signing so we never transfer the client_secret
        ksort($params);
        $timeStr = gmdate('Y-m-d H:i:s');
        $this->reqHeaders[] = "Date: {$timeStr}";
        $data = "/{$url}\n{$timeStr}\n";
        foreach ($params as $k => $v) {
            $data .= "{$k}={$v}\n";
        }
        $rawDigest = hash_hmac('sha1', $data, $this->conf['capture.client_secret'], true);
        $b64 = base64_encode($rawDigest);
        $this->reqHeaders[] = "Authorization: Signature {$this->conf['capture.clientId']}:{$b64}";
    }

    /**
     * Retreive a JUMP User from capture using the provided token.
     */
    public function fetchUserByUuid($uuid, $token = null)
    {
        $data = $this('entity', array('uuid' => $uuid, 'type_name'=>'user'), $token);
        $user = User::__set_state($data);
        return $user;
    }

    public function getToken($uuid)
    {
        $resp = $this('access/getAccessToken', array('uuid' => $uuid, 'type_name' => 'user'));
        $out = new \stdClass();
        $out->token = $resp['accessToken'];
        //token expires in 1 hour, so lets give a 5 minute window where it can renew a tad early.
        $out->expires = time() + 60 * 55;
        return $out;
    }

    public function getUserSchema()
    {
        $resp = $this('entityType', array('type_name' => 'user'));
        return $resp;
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

    public function getPriority()
    {
        return 0;
    }
}
