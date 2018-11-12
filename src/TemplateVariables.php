<?php


namespace Taitava\EUCookieLawPopup;


use SilverStripe\View\Requirements;
use SilverStripe\View\TemplateGlobalProvider;

class TemplateVariables implements TemplateGlobalProvider
{
	
	/**
	 * Called by SSViewer to get a list of global variables to expose to the template, the static method to call on
	 * this class to get the value for those variables, and the class to use for casting the returned value for use
	 * in a template
	 *
	 * If the method to call is not included for a particular template variable, a method named the same as the
	 * template variable will be called
	 *
	 * If the casting class is not specified for a particular template variable, ViewableData::$default_cast is used
	 *
	 * The first letter of the template variable is case-insensitive. However the method name is always case sensitive.
	 *
	 * @return array Returns an array of items. Each key => value pair is one of three forms:
	 *  - template name (no key)
	 *  - template name => method name
	 *  - template name => array(), where the array can contain these key => value pairs
	 *     - "method" => method name
	 *     - "casting" => casting class to use (i.e., Varchar, HTMLFragment, etc)
	 */
	public static function get_template_global_variables()
	{
		return [
			'CookiePolicyLink',
			'DeleteAllCookiesLink',
		];
	}
	
	public static function CookiePolicyLink()
	{
		return EUCookieLawPopup::getCookiePolicyLink();
	}
	
	public static function DeleteAllCookiesLink()
	{
		EUCookieLawPopup::RequireDeleteAllCookiesJavaScriptMethod();
		Requirements::customScript(<<<JS
		function DeleteAllCookies()
		{
			window.deleteAllCookies();
			InitializeEUCookieLawPopup(); //Make the popup box reappear
			jQuery(document).trigger("user_cookie_consent_changed", {'consent' : false}); //Fire any possible events related to the user changing the consent.
		}
JS
		, __METHOD__);
		return 'javascript:DeleteAllCookies();';
	}
}