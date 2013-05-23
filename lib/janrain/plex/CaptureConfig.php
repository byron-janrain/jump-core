<?php
namespace janrain\plex;

class CaptureConfig extends AbstractConfig implements CaptureConfigInterface {

	public function __construct(Array $data) {
		static $REQ_KEYS = array('tokenUrl', 'capture.appId', 'capture.clientId', 'capture.captureServer', 'capture.loadJsUrl');
		parent::__construct($data, $REQ_KEYS);
	}

	public function setTokenUrl($url) {
		$this['tokenUrl'] = $url;
	}

	public function setCaptureAppId($id) {
		$this['capture.appId'] = $id;
	}

	public function setCaptureClientId($id) {
		$this['capture.clientId'] = $id;
	}

	public function setCaptuerCaptureServer($url) {
		$this['capture.captureServer'] = $url;
	}

	public function setCaptureLoadJsUrl($url) {
		$this['capture.loadJsUrl'] = $url;
	}
}
