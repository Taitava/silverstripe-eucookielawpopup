/*
 * This is copied 2018-11-12 from https://stackoverflow.com/a/41641134/2754026
 * Author: [SpYk3HH](https://stackoverflow.com/users/900807/spyk3hh)
 * Modifications:
 *  - Removed the showLog parameter as it's not needed in production.
 *  - Removed the `if (!window['deleteAllCookies'] && document['cookie'])` check
 */


window.deleteAllCookies = function ()
{
	var arrCookies = document.cookie.split(';'),
		arrPaths = location.pathname.replace(/^\//, '').split('/'), //  remove leading '/' and split any existing paths
		arrTemplate = ['expires=Thu, 01-Jan-1970 00:00:01 GMT', 'path={path}', 'domain=' + window.location.host, 'secure='];  //  array of cookie settings in order tested and found most useful in establishing a "delete"
	for (var i in arrCookies)
	{
		var strCookie = arrCookies[i];
		if (typeof strCookie == 'string' && strCookie.indexOf('=') >= 0)
		{
			var strName = strCookie.split('=')[0];  //  the cookie name
			for (var j = 1; j <= arrTemplate.length; j++)
			{
				if (document.cookie.indexOf(strName) < 0) break; // if this is true, then the cookie no longer exist
				else
				{
					var strValue = strName + '=; ' + arrTemplate.slice(0, j).join('; ') + ';';  //  made using the temp array of settings, putting it together piece by piece as loop rolls on
					if (j == 1) document.cookie = strValue;
					else
					{
						for (var k = 0; k <= arrPaths.length; k++)
						{
							if (document.cookie.indexOf(strName) < 0) break; // if this is true, then the cookie no longer exist
							else
							{
								var strPath = arrPaths.slice(0, k).join('/') + '/'; //  builds path line
								strValue = strValue.replace('{path}', strPath);
								document.cookie = strValue;
							}
						}
					}
				}
			}
		}
	}
	
	return document.cookie;
};
