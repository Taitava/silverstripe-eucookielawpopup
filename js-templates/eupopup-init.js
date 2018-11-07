$(document).ready(function ()
{
	if ($("$popup_element_jquery_selector").length > 0)
	{
		$(document).euCookieLawPopup().init({
			cookiePolicyUrl:                "$cookiePolicyUrl",
			popupPosition:                  "$popupPosition",
			colorStyle:                     "$colorStyle",
			compactStyle:                   $compactStyle,
			popupTitle:                     "$popupTitle",
			popupText:                      "$popupText",
			buttonContinueTitle:            "$buttonContinueTitle",
			buttonLearnmoreTitle:           "$buttonLearnmoreTitle",
			buttonLearnmoreOpenInNewWindow: $buttonLearnmoreOpenInNewWindow,
			agreementExpiresInDays:         $agreementExpiresInDays,
			autoAcceptCookiePolicy:         $autoAcceptCookiePolicy,
			htmlMarkup:                     $htmlMarkup
		});
	}
});