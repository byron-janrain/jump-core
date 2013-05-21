<?php
namespace janrain\plex;

use \ArrayObject;

class CaptureConfig extends ArrayObject implements CaptureConfigInterface {

	public function __construct(Array $data = array()) {
		parent::__construct($data);
        foreach (static::getRequiredKeys() as $key) {
            if (empty($data[$key])) {
                throw new \InvalidArgumentException("Required configuration option {$key} not found!");
            }
            $this[$key] = $data[$key];
        }

		/*$this['capture.clientId'] = $data['clientId'];
		$this['capture.name'] = $data['captureName'];
		$this['engage.name'] = $data['engageName'];
		$this['capture.id'] = $data['captureAppId'];
		$this['engage.tokenUrl'] = $data['tokenUrl'];*/
	}


	protected static $REQ_KEYS = array('tokenUrl', 'capture.appId', 'capture.clientId', 'capture.captureServer', 'capture.loadJsUrl');
	public static function getRequiredKeys() {
		return static::$REQ_KEYS;
	}
}
