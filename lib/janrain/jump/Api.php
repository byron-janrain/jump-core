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
		$this->clientId = $opts['capture.clientId'];
		$this->clientSecret = $opts['capture.clientSecret'];
		$this->data = array(
			'client_id' => $this->clientId,
			'client_secret' => $this->clientSecret,
			);
		$this->ctx = array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-type: application/x-www-form-urlencoded',
				));
		$this->url = $opts['capture.captureServer'];
		if ($this->url[(strlen($this->url) - 1)] !== '/') {
			$this->url .= '/';
		}
	}

	public function __invoke($url, $params) {
		$params = array_merge($this->data, $params);
		$this->ctx['http']['content'] = http_build_query($params);
		$stream = stream_context_create($this->ctx);
		return json_decode(file_get_contents($this->url . $url, false, $stream));
	}

	public function fetchUserBy()
	{

	}
}
