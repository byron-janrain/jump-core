<?php
namespace janrain\plex;

/**
 * This interface represents the pre-render contract for all renderable Plex features.
 */
interface RenderableInterface {

	/**
	 * Get an array of external scripts.  Likely these will be dependent libraries and should be rendered by the CMS prior to
	 * the getStartHeadJs(), getSettingsHeadJs(), getEndHeadJs() chain.
	 *
	 * @return Array
	 */
	public function getHeadJsSrcs();

	/**
	 * Start the JS Output. The string representing the start of JUMP javascript to be placed within HTML Head tag.
	 * Does not contain opening <script>.  If this Renderable doesn't require JS, this should return empty string.
	 * @return string
	 */
	public function getStartHeadJs();

	/**
	 * Get the javascript settings for this Renderable JUMP object. A block of settings in the form
	 * "janrain.settings.package.option = 'value'\n". Empty string is returned if no settings are needed.
	 *
	 * @return string
	 *
	 */
	public function getSettingsHeadJs();

	/**
	 * Get the closing javascript content and load.js src. The closing block of head javascript.
	 * Does not include a </script>.  If no JS required, this returns empty string.
	 *
	 * @return string
	 */
	public function getEndHeadJs();

	/**
	 * Get the hrefs of the external CSS this renderable requires. If renderable does not depend on any external css files
	 * an empty array is returned.
	 *
	 * @return Array
	 */
	public function getCssHrefs();

	/**
	 * Get the inline style needed for this renderable. Does not include opening or closing style tags.  Returns empty string
	 * if no styles needed.
	 *
	 * @return string 	sup
	 */
	public function getCss();

	/**
	 * Get the body content of this Renderable. Returns html markup, or empty string.
	 *
	 * @return string
	 */
	public function getHtml();
}
