<?php
namespace janrain\plex;

class CaptureConfig extends AbstractConfig implements CaptureConfigInterface
{
	public function __construct(Array $data)
	{
		static $REQ_KEYS = array('capture.appId', 'capture.clientId', 'capture.captureServer', 'jumpUrl');
		parent::__construct($data, $REQ_KEYS);
	}

	public function setCaptureAppId($id)
	{
		$this['capture.appId'] = $id;
	}

	public function setCaptureClientId($id)
	{
		$this['capture.clientId'] = $id;
	}

	public function setCaptureCaptureServer($url)
	{
		$this['capture.captureServer'] = $url;
	}

	public function setJumpUrl($url)
	{
		$this['jumpUrl'] = $url;
	}
}
