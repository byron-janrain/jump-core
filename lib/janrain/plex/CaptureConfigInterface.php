<?php
namespace janrain\plex;

interface CaptureConfigInterface extends ConfigInterface
{
	public function getTokenUrl();

	public function setTokenUrl($url);

	public function getCaptureAppId();

	public function setCaptureAppId($id);

	public function getCaptureClientId();

	public function setCaptureClientId($id);

	public function getCaptureCaptureServer();

	public function setCaptuerCaptureServer($url);

	public function getCaptureLoadJsUrl();

	public function setCaptureLoadJsUrl($url);
}
