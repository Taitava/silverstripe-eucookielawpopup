<?php
/**
 * Class EUCookieLawPopup
 *
 * An extension for SiteTree.
 */
class EUCookieLawPopup extends Extension
{
	
	/**
	 * If true, 'EU cookie law popup' related CSS and JavaScript files are automatically defined as requirements during
	 * each page request.
	 *
	 * @conf bool
	 */
	private static $enabled = true;
	
	/**
	 * If true, adds jquery from SS framework as a requirement automatically. Requires $enabled config value to be true
	 * too, otherwise does nothing.
	 *
	 * @conf bool
	 */
	private static $use_jquery_from_framework = false;
	
	/**
	 * You must have an HTML element matching this jQuery selector located somewhere in your HTML code. For example:
	 *
	 *     <div class="eupopup"></div>
	 *
	 * The element can be empty.
	 *
	 * @conf string
	 */
	private static $popup_element_jquery_selector = '.eupopup';
	
	/**
	 * If this is an integer, the "learn more" link in the popup box will take the user to this page. Otherwise the $options['cookiePolicyUrl'] config option will be used.
	 *
	 * @conf false|int
	 */
	private static $cookie_policy_page_id = false;
	
	/**
	 * Options that will be passed to the JavaScript library. See vendor/taitava/eucookielawpopup/_config/eucookielawpopup.yml
	 * to see all available option variables and their default values.
	 *
	 * @conf array
	 */
	private static $options = [];
	
	public function contentcontrollerInit()
	{
		if (static::config()->get('enabled'))
		{
			static::RequireLibraries();
			static::InitializePopup();
		}
	}
	
	public static function RequireLibraries()
	{
		//jQuery library
		if (static::config()->get('use_jquery_from_framework')) Requirements::javascript('framework/thirdparty/jquery/jquery.js'); //Include jQuery from the framework only if permitted. Otherwise the developer is assumed to include her own version of jQuery.
		
		//jquery-eu-cookie-law-popup library
		Requirements::javascript('eucookielawpopup/vendor/wimagguc/jquery-eu-cookie-law-popup/js/jquery-eu-cookie-law-popup.js');
		Requirements::css('eucookielawpopup/vendor/wimagguc/jquery-eu-cookie-law-popup/css/jquery-eu-cookie-law-popup.css');
	}
	
	/**
	 * The window.deleteAllCookies() method is not necessarily needed by the actual cookie consent popup notification, so it's not
	 * included by default.
	 *
	 * The method is included only if you use $RemoveAllCookiesLink variable in your template.
	 */
	public static function RequireDeleteAllCookiesJavaScriptMethod()
	{
		Requirements::javascript('eucookielawpopup/js/delete-all-cookies.js');
	}
	
	public static function InitializePopup()
	{
		Requirements::javascriptTemplate('eucookielawpopup/js-templates/eupopup-init.js', static::prepare_javascript_options());
	}
	
	/**
	 * @param $config
	 * @return array
	 */
	private static function unprepared_javascript_options()
	{
		return (array) static::config()->get('options');
	}
	
	private static function prepare_javascript_options()
	{
		$config = static::config();
		$options = self::unprepared_javascript_options();
		
		//Popup box element selector
		$options['popup_element_jquery_selector'] = $config->get('popup_element_jquery_selector');
		
		//Cookie policy page URL
		$options['cookiePolicyUrl'] = static::getCookiePolicyLink(); //This returns either the same value which $options['cookiePolicyUrl'] already contains, or an overriding value.
		//Escape
		array_walk($options, function ($option_value) {
			return Convert::raw2json($option_value);
		});
		
		return $options;
	}
	
	public static function getCookiePolicyLink()
	{
		$options = self::unprepared_javascript_options();
		$cookie_policy_page_id = static::config()->get('cookie_policy_page_id');
		if ($cookie_policy_page_id > 0)
		{
			/** @var SiteTree $cookie_policy_page */
			$cookie_policy_page = SiteTree::get()->byID($cookie_policy_page_id);
			if (is_object($cookie_policy_page) && $cookie_policy_page->isPublished())
			{
				//Override the static 'cookiePolicyUrl' option, but only if we found an actually existing (and published) cookie policy page
				return $cookie_policy_page->Link();
			}
		}
		
		//Return the static url
		return $options['cookiePolicyUrl'];
	}
	
	private static function config()
	{
		return Config::inst()->forClass(static::class);
	}
}