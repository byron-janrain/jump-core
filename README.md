# jump-core #

## JUMP Extensions Core ##

## Developing ##

Development on JUMP Core requires PHP 5.5 to perform unit testing.  The code itself is php 5.3 compatible and should not produce errors with E_ALL or E_STRICT error settings when used in
a dependent library.

Our code convention follows the FIG standards of PSR-0, PSR-1, and PSR-2 for maximum interoperability.

## Internationalization ##

Currently there's only the hook for translating.  The general concept would be something like

class ThingThatOutputsReadableStrings implements Translatable
{
	public function __construct()
	{
		$this->xlate = Intl::createForLang('en_us');
	}


	protected $xlate;
	public function __($stringToTranslate)
	{
		return call_user_func_array([$this->xlate, 'translate'], func_get_args());
	}
}

In theory, we'll have one of two possible scenarios.


