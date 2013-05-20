<?php
namespace janrain\plex;

use \ArrayObject;

class CaptureConfig extends ArrayObject implements CaptureConfigInterface {

	public function __construct(Array $data = array()) {
		parent::__construct($data);
		/*$this['capture.clientId'] = $data['clientId'];
		$this['capture.name'] = $data['captureName'];
		$this['engage.name'] = $data['engageName'];
		$this['capture.id'] = $data['captureAppId'];
		$this['engage.tokenUrl'] = $data['tokenUrl'];*/
	}
}
