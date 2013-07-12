<?php
namespace janrain\plex\capture;

use janrain\plex\AbstractFeature;
use janrain\plex\RenderableInterface;

class Capture extends AbstractFeature implements RenderableInterface
{
	protected $config;

	public function __construct(CaptureConfig $c)
	{
		$this->config = $c;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHeadJsSrcs()
	{
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getStartHeadJs()
	{
		$out = "opts.packages.push('capture');\n";
		return $out;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSettingsHeadJs()
	{
		$out = "\n//Start Capture Settings
			opts.capture.appId = '{$this->config['capture.appId']}';
			opts.capture.clientId = '{$this->config['capture.clientId']}';
			opts.capture.captureServer = '{$this->config['capture.captureServer']}';
			opts.capture.recaptchaPublicKey = '6LeVKb4SAAAAAGv-hg5i6gtiOV4XrLuCDsJOnYoP';
			opts.capture.redirectUri = document.location.href;
			//opts.capture.loadJsUrl = 'd29usylhdk1xyu.cloudfront.net/load/.default';
			opts.capture.flowName = 'plugins';
			opts.capture.responseType = 'token';
			/*TODO: remove by default.  allow engage to set this if it needs it.*/
			opts.tokenUrl = document.location.href;
			opts.tokenAction = 'event';
			opts.plex.loadJsUrl = '//d29usylhdk1xyu.cloudfront.net/load/.default';
			//End Capture Settings\n";
		return $out;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEndHeadJs()
	{
		$out =
			"function janrainCaptureWidgetOnLoad() {
				janrain.events.onCaptureLoginSuccess.addHandler(
					function (result) {
						console.log(result);
						janrain.plex.do('login', {token:result.accessToken, uuid:result.userData.uuid});
						janrain.capture.ui.modal.close();
					});
				janrain.events.onCaptureLoginFailed.addHandler(
					function () {
						console.log('Sign in failure!');
						janrain.capture.ui.modal.close();
					});
				janrain.events.onCaptureRegistrationSuccess.addHandler(
					function (result) {
						console.log('Registration Success!');
						console.log(result);
						janrain.plex.do('register', {token:result.accessToken, uuid:result.userData.uuid});
						janrain.capture.ui.modal.close();
					});
				janrain.capture.ui.start();
			}\n";
		return $out;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCssHrefs()
	{
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCss()
	{
		return file_get_contents(dirname(__DIR__) . '/styles.css');
	}

	/**
	 * @todo: remove screens when widget manager delivers them in the flow
	 * {@inheritdoc}
	 */
	public function getHtml()
	{
		//$doEngage = Core::getFeature('Engage')->isEnabled();
		$doEngage = false;
		ob_start();
		require dirname(__DIR__) . '/screens.html';
		$screens = ob_get_clean();
		return "<a href='#' class='capture_modal_open'>Sign In</a>\n{$screens}\n";
	}

	/**
	 * @inheritsDoc
	 *
	 * Returns 1
	 */
	public function getPriority()
	{
		return 1;
	}
}
