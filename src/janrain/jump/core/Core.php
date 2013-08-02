<?php
namespace janrain\jump\core;

use janrain\jump\AbstractFeature;
use janrain\jump\Renderable;

class Core extends AbstractFeature implements Renderable
{
    protected $config;

    public function __construct(CoreConfig $c)
    {
        $this->config = $c;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadJsSrcs()
    {
        return array(
            '//d3t53pw1y3gpqf.cloudfront.net/localstorage-polyfill.js',
            '//d3t53pw1y3gpqf.cloudfront.net/prototype-fix-pre1.7.1.js',
            );
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
            opts.plex = {};
            window.janrain.plex = {
                do: function (actionName, params) {
                    params.do = actionName;
                    janrain.plex.go(opts.plex.jumpUrl, params);
                },
                go: function (url, params) {
                    if ('undefined' !== typeof params) {
                        if ('?' != url.slice(-1,1)) {
                            url += '?';
                        }
                        for (var k in params) {
                            url += '&' + encodeURIComponent(k) + '=' + encodeURIComponent(params[k]);
                        }
                    }
                    window.location.href = url;
                }
            }\n";
        return $out;
    }

    public function getSettingsHeadJs()
    {
        $out = "opts.plex.jumpUrl = '{$this->config['jumpUrl']}'\n";
        return $out;
    }

    public function getEndHeadJs()
    {
        $out = "function isReady() {janrain.ready=true;}
            if (document.addEventListener) {
                document.addEventListener('DOMContentLoaded', isReady, false);
            } else {
                window.attachEvent('onload', isReady);
            }
            var e = document.createElement('script');
            e.type = 'text/javascript';
            e.id = 'janrainAuthWidget';
            e.src = opts.plex.loadJsUrl;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(e, s);
            })();\n";
        return $out;
    }

    public function getCssHrefs()
    {
        $out = array();
        return $out;
    }

    public function getCss()
    {
        $out = '';
        return $out;
    }

    public function getHtml()
    {
        return '';
    }

    public function getPriority()
    {
        return 0;
    }
}
