<?php
namespace janrain\jump;

/**
* Janrain Internationalization class usage:
* Janrain\Intl::createForLang('en_us')
*/
class Intl
{

	protected $lang;
	protected $data;

	public function __construct($lang)
	{
		$this->lang = $lang;
		#implement loading data from translation file or system cache.
	}

	public function __invoke($templateString)
	{
		#make sure we're translating a string
		if (!is_string($templateString)) {
			throw new \InvalidArgumentException();
		}
		#we've got a string, check for preprocessor
		$args = func_get_args();
		if (count($args) > 1) {
			$langProc = $args[1];
			if (is_callable($langProc)) {
				#pre-processor found, run it this string with this special function
				$templateString = $langProc($templateString);
				unset($args[1]);
			}
			#preprocessor run (if needed), all args[0] should be the translation phrase, and all other args should be replacements
			return call_user_func_array(array($this, 'translate'), $args);
		}
		return $this->translate($templateString);
	}

	protected function translate()
	{
		return func_get_arg(0);
	}

	public static function createForLang($lang = 'en_us')
	{
		return new static($lang);
	}
}
