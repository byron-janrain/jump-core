<?php
namespace janrain\plex;

class Core extends AbstractFeature implements RenderableInterface
{
	protected $config;

	public function __construct(\janrain\plex\CoreConfig $c)
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
		$out = "(function(){
			var opts;
			if (typeof window.janrain !== 'object') {window.janrain = {};}
			if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
			opts = window.janrain.settings;
			if (typeof opts.packages !== 'object') opts.packages = [];
			if (typeof opts.capture !== 'object') opts.capture = {};
			opts.plex = {}\n";
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
