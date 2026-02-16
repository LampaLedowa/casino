iapiConf = {"casinoname":"totalcasino","loginServer":"login.totalcasino.pl","imsLoginDomain":"totalcasino.pl","clientSkin":"totalcasino","clientType":"casino","clientPlatform":"web","clientVersion":null,"systemId":"1124","serviceType":"GamePlay","loginDomainRetryCount":"2","loginDomainRequestTimeout":"30","loginDomainRetryInterval":"1","fitToPlaySubmissionRequired":"0","onlypostrequestsforlogout":"1","fidoAuth":"0","clientUrl_casino":"https://cachedownload.totalcasino.pl/casinoclient.html","clientUrl_ngm_desktop":"https://cachedownload.totalcasino.pl/ngmdesktop/casinoclient.html","clientUrl_ngm_mobile":"https://games.totalcasino.pl/casinomobile/casinoclient.html"};
 // whitelisted method name "staticLoadFinished"
var onStaticLoad = iapiOnPASLoad;
if (typeof iapiBaseLogin === 'undefined') {
    var staticIntegrScript = document.createElement('script');
    staticIntegrScript.type = 'text/javascript';
    staticIntegrScript.src = getHttpProtocol() + '://login.totalcasino.pl/jswrapper/staticintegration.js.php?ver=ae5875711e37fd5efe8633941777217201c989dc:&min=1&pasLogin=0';

    if (typeof (onStaticLoad) === 'function') {
        staticIntegrScript.onload = staticIntegrScript.onerror = onStaticLoad;
    }

    document.getElementsByTagName('head')[0].appendChild(staticIntegrScript);
}

function isSecureAttr()  {
    return iapiConf['setSecureAttr'] == "false" ? false : true;
}

function getHttpProtocol() {
    return isSecureAttr() ? "https" : "http";
}
