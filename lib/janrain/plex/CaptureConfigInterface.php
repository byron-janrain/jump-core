<?php
namespace janrain\plex;

/**
 * Capture specific configuration mutators.
 */
interface CaptureConfigInterface extends ConfigInterface
{
	public function setCaptureAppId($id);
	public function setCaptureClientId($id);
	public function setCaptuerCaptureServer($url);
	public function setCaptureLoadJsUrl($url);
}
