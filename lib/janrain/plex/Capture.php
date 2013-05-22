<?php
namespace janrain\plex;

class Capture implements RenderableInterface {

    protected $config;

	public function __construct(CaptureConfigInterface $config) {
        $this->config = $config;
	}

	public function getJsSrcs() {
		return array();//'https://d7v0k4dt27zlp.cloudfront.net/assets/capture_client.js');
	}

	public function getStartHeadJs() {
		$out = "(function(){
            window.janrain = { settings: { packages: [], capture: {}}};
			// if (typeof window.janrain !== 'object') window.janrain = {};
			// if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
			// if (typeof window.janrain.settings.packages !== 'object') window.janrain.settings.packages = [];
			// if (typeof window.janrain.settings.capture !== 'object') window.janrain.settings.capture = {};
            janrain.settings.packages.push('capture');\n";
		return $out;
	}

	public function getSettingsHeadJs() {
		$out = "\n//Start Janrain Settings
			janrain.settings.capture.appId = '{$this->config['capture.appId']}';
			janrain.settings.capture.clientId = '{$this->config['capture.clientId']}';
			janrain.settings.capture.captureServer = '{$this->config['capture.captureServer']}';
			janrain.settings.capture.recaptchaPublicKey = '6LeVKb4SAAAAAGv-hg5i6gtiOV4XrLuCDsJOnYoP';
			janrain.settings.capture.redirectUri = document.location.href;
			//janrain.settings.capture.loadJsUrl = 'd16s8pqtk4uodx.cloudfront.net/\$this->engageName/load.js';
            janrain.settings.capture.loadJsUrl = '{$this->config['capture.loadJsUrl']}';
			janrain.settings.capture.flowName = 'plugins';
			janrain.settings.capture.registerFlow = 'socialRegistration';
			janrain.settings.capture.responseType = 'token';
			janrain.settings.tokenUrl = '{$this->config['tokenUrl']}';
			janrain.settings.tokenAction = 'event';
			//End Janrain Settings\n";
		return $out;
	}

	public function getEndHeadJs() {
		$out =
			"function isReady() {janrain.ready=true;}
			if (document.addEventListener) {
				document.addEventListener('DOMContentLoaded', isReady, false);
			} else {
				window.attachEvent('onload', isReady);
			}
			var e = document.createElement('script');
			e.type = 'text/javascript';
			e.id = 'janrainAuthWidget';
			e.src = '//{$this->config['capture.loadJsUrl']}';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(e, s);
			})();
			</script>
			<script type='text/javascript'>
			function janrainCaptureWidgetOnLoad() {
				janrain.events.onCaptureLoginSuccess.addHandler(
					function (result) {
						alert('Success: this is your token ' + result.accessToken);
                        janrain.capture.ui.modal.close();
					});
                janrain.events.onCaptureLoginFailed.addHandler(
                    function () {
                        console.log('Sign in failure!');
                        janrain.capture.ui.modal.close();
                    });
                janrain.events.onCaptureRegistrationSuccess.addHandler(
                    function () {
                        console.log('Registration Success!');
                        janrain.capture.ui.modal.close();
                    });
				janrain.capture.ui.start();
 			}\n";
		return $out;
	}
	public function getCssHrefs() {
		return array(
			'//d3hmp0045zy3cs.cloudfront.net/2.1.10/quilt.css',
			'//d3hmp0045zy3cs.cloudfront.net/2.1.10/widgets.css',
			);
	}
	public function getCss() {
		return file_get_contents(__DIR__ . '/../plex/styles.css');
	}
	public function getHtml() {
        $screens = file_get_contents(__DIR__ . '/../plex/screens.html');
		return "<a href='#' class='capture_modal_open'>Sign In</a>\n{$screens}\n";
	}
}
