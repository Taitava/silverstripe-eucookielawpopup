# Taitava/silverstripe-eucookielawpopup

Uses jQuery and [wimagguc/jquery-eu-cookie-law-popup](https://github.com/wimagguc/jquery-eu-cookie-law-popup) to create a popup element telling the visitor that the website uses cookies. Note that this module is basically just a wrapper on the latter mentioned library in order to allow easy implementations in SilverStripe projects.

## Requirements

This module requires SilverStripe 4.x framework. The CMS module is also required.

## Installation

### 1. Install the module using composer
```bash
composer require "taitava/silverstripe-eucookielawpopup:*"
```

### 2. Add this HTML snippet somewhere in your themes/***/templates/Page.ss template
```html
<div class="eupopup"></div>
```

The popup message will be rendered into that element. If you want to change the `class` attribute to something else, or use an `ID` attribute instead of a `class`, you can configure a custom jQuery selector in your application's YAML config:

Create a file *app/_config/eucookielawpopup.yml*:
```YAML
Taitava\EUCookieLawPopup\EUCookieLawPopup:
  popup_element_jquery_selector: '.eupopup'
```

Remember to run */dev/build?flush=all* in your browser after changing the selector.

### 3. All configuration options

These are the default values:

```YAML
Taitava\EUCookieLawPopup\EUCookieLawPopup:
  enabled: true #If true, 'EU cookie law popup' related CSS and JavaScript files are automatically defined as requirements during each page request.
  use_jquery_from_framework: true #If true, adds jquery from SS framework as a requirement automatically. Requires $enabled config value to be true too, otherwise does nothing.
  popup_element_jquery_selector: '.eupopup' #You must have an HTML element matching this jQuery selector located somewhere in your HTML code. For example: <div class="eupopup"></div> The element can be empty.
  options:
    cookiePolicyUrl: "/cookie-policy"
    popupPosition: "top"
    colorStyle: "default"
    compactStyle: "false"
    popupTitle: "This website is using cookies"
    popupText: "We use cookies to ensure that we give you the best experience on our website. If you continue without changing your settings, we'll assume that you are happy to receive all cookies on this website."
    buttonContinueTitle: "Continue"
    buttonLearnmoreTitle: "Learn more"
    buttonLearnmoreOpenInNewWindow: "true"
    agreementExpiresInDays: 30
    autoAcceptCookiePolicy: "false"
    htmlMarkup: "null"
```

## Future plans
 - Make it possible to configure the `cookiePolicyURL` in the admin panel by selecting a page in SiteConfig.
 - Perhaps a predefined way to initialize JavaScript snippets (that use cookies) *after* the user has accepted to receive cookies. It is possible even now, but requires some work: http://www.wimagguc.com/2018/05/gdpr-compliance-with-the-jquery-eu-cookie-law-plugin/#gdpr_compliance

Have your own ideas? Please let me know in the issues! :) Pull requests are also welcome.

## Author

The original JavaScript library: [wimagguc/jquery-eu-cookie-law-popup](https://github.com/wimagguc/jquery-eu-cookie-law-popup).

The SilverStripe module:
Jarkko Linnanvirta
jarkko@taitavasti.fi