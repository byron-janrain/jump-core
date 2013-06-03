<?php
namespace janrain\jump;

use \ArrayAccess;

class Api
{

	protected $clientId;
	protected $clientSecret;

	protected $ctx;
	protected $data;

	public function __construct(ArrayAccess $opts) {
		/*$this->clientId = $opts['capture.clientId'];
		$this->clientSecret = @$opts['capture.clientSecret'];
		$this->data = array(
			'client_id' => $this->clientId,
			'client_secret' => $this->clientSecret,
			);*/
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
		echo '<pre>';
		$data = $this('entity', array('uuid' => $uuid, 'token' => $token, 'type_name'=>'user'));
		$user = User::__set_state($data);
		var_dump($user);
		var_dump($user->email);
		var_dump($user->firstName);
		var_dump($user->lastName);
		return $user;
	}
}
