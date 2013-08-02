<?php
namespace janrain\jump\capture;

use janrain\jump\AbstractFeature;
use janrain\jump\Renderable;

class Capture extends AbstractFeature implements Renderable
{
    protected $config;
    protected $api;

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
            opts.plex.loadJsUrl = '//rpxnow.com/load/.default';\n";
        return $out . "//End Capture Settings\n";
    }

    /**
     * {@inheritdoc}
     */
    public function getEndHeadJs()
    {
        $out = '';
        if ($token = $this->config['capture.session->token']) {
            $expires = gmdate('D, j M Y H:i:s', $this->config['capture.session->expires']) . ' GMT';
            $out .=
                "window.localStorage.setItem('janrainCaptureToken', '{$token}');
                window.localStorage.setItem('janrainCaptureToken_Expires', '{$expires}');\n";
        } else {
            $out .=
                "window.localStorage.removeItem('janrainCaptureToken');
                window.localStorage.removeItem('janrainCaptureToken_Expires');\n";
        }
        $out .=
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
                        janrain.plex.do('login', {token:result.accessToken, uuid:result.userData.uuid});
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
        $out = array('//d3t53pw1y3gpqf.cloudfront.net/styles/janrain.css');
        #todo decide how we're going to detect mobile
        /*if (false) {
            $out[] = '//d3t53pw1y3gpqf.cloudfront.net/styles/janrain-mobile.css';
        }*/
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getCss()
    {
        #todo enable css customization by file upload or database storage.
        return '';
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
        require __DIR__ . '/screens.html';
        $screens = ob_get_clean();
        return
            "<a href='#' id='captureSignInLink' class='capture_modal_open'>Sign In / Sign Up</a><br/>
            <a href='#' id='captureProfileLink' onclick='janrain.capture.ui.renderScreen(\"editProfile\")'>Edit Profile</a><br/>
            <a href='#' id='captureSignOutLink' class='capture_end_session'>Sign Out</a>\n{$screens}\n";
    }

    /**
     * @inheritsDoc
     *
     * Returns 1
     */
    public function getPriority()
    {
        return 5;
    }
}
