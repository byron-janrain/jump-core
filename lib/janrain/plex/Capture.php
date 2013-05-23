<?php
namespace janrain\plex;

class Capture implements RenderableInterface
{
    protected $config;

    public function __construct(CaptureConfigInterface $config)
    {
        $this->config = $config;
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
        $out = "(function(){
            var opts;
            if (typeof window.janrain !== 'object') {window.janrain = {};}
            if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
            opts = window.janrain.settings;
            if (typeof opts.packages !== 'object') opts.packages = [];
            if (typeof opts.capture !== 'object') opts.capture = {};
            opts.packages.push('capture');\n";
        $out .=
            "if (typeof Prototype !== 'undefined') {
                var protVer = 0;
                var m = 100;
                Prototype.Version.split('.').forEach(
                    function (value) {
                        protVer += m * value;
                        m /= 10;
                    });
                if (protVer < 171) {
                    //FIX PROTOTYPE
                    Array.prototype.map = function(callback, thisArg) {
                        var T, A, k;
                        if (this == null) throw new TypeError(' this is null or not defined');
                        var O = Object(this);
                        var len = O.length >>> 0;
                        if (typeof callback !== 'function') throw new TypeError(callback + ' is not a function');
                        if (thisArg) T = thisArg;
                        A = new Array(len);
                        k = 0;
                        while (k < len) {
                            var kValue, mappedValue;
                            if (k in O) {
                                kValue = O[k];
                                mappedValue = callback.call(T, kValue, k, O);
                                A[k] = mappedValue;
                            }
                            k++;
                        }
                        return A;
                    };
                }
            }\n";
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsHeadJs()
    {
        $out = "\n//Start Janrain Settings
            opts.capture.appId = '{$this->config['capture.appId']}';
            opts.capture.clientId = '{$this->config['capture.clientId']}';
            opts.capture.captureServer = '{$this->config['capture.captureServer']}';
            opts.capture.recaptchaPublicKey = '6LeVKb4SAAAAAGv-hg5i6gtiOV4XrLuCDsJOnYoP';
            opts.capture.redirectUri = document.location.href;
            opts.capture.loadJsUrl = 'd16s8pqtk4uodx.cloudfront.net/default/load.js';
            opts.capture.flowName = 'plugins';
            opts.capture.responseType = 'token';
            /*TODO: remove by default.  allow engage to set this if it needs it.*/
            opts.tokenUrl = document.location.href;
            opts.tokenAction = 'event';
            //End Janrain Settings\n";
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndHeadJs()
    {
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

    /**
     * {@inheritdoc}
     */
    public function getCssHrefs()
    {
        return array(
            '//d3hmp0045zy3cs.cloudfront.net/2.1.10/quilt.css',
            '//d3hmp0045zy3cs.cloudfront.net/2.1.10/widgets.css',
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getCss()
    {
        return file_get_contents(dirname(__DIR__) . '/plex/styles.css');
    }

    /**
     * @todo: remove screens when widget manager delivers them in the flow
     * {@inheritdoc}
     */
    public function getHtml()
    {
        ob_start();
        require dirname(__DIR__) . '/plex/screens.html';
        $screens = ob_get_clean();
        return "<a href='#' class='capture_modal_open'>Sign In</a>\n{$screens}\n";
    }
}
