<?php

namespace Taitava\EUCookieLawPopup;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

/**
 * Class EUCookieLawPopup
 *
 * An extension for SiteTree.
 */
class EUCookieLawPopup extends Extension
{
	use Configurable;
	
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
	private static $use_jquery_from_framework = true;
	
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
		if (static::config()->get('use_jquery_from_framework')) Requirements::javascript('silverstripe/admin: thirdparty/jquery/jquery.js'); //Include jQuery from the framework only if permitted. Otherwise the developer is assumed to include her own version of jQuery.
		
		//jquery-eu-cookie-law-popup library
		Requirements::javascript('taitava/silverstripe-eucookielawpopup: vendor/wimagguc/jquery-eu-cookie-law-popup/js/jquery-eu-cookie-law-popup.js');
		Requirements::css('taitava/silverstripe-eucookielawpopup: vendor/wimagguc/jquery-eu-cookie-law-popup/css/jquery-eu-cookie-law-popup.css');
	}
	
	public static function InitializePopup()
	{
		Requirements::javascriptTemplate('taitava/silverstripe-eucookielawpopup: js-templates/eupopup-init.js', static::prepare_javascript_options());
	}
	
	private static function prepare_javascript_options()
	{
		$config = static::config();
		$options = (array) $config->get('options');
		
		//Popup box element selector
		$options['popup_element_jquery_selector'] = $config->get('popup_element_jquery_selector');
		
		//Escape
		array_walk($options, function ($option_value) {
			return Convert::raw2json($option_value);
		});
		
		return $options;
	}
}