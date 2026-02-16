function replaceImsDomain() {
    if (iapiConf && iapiConf.imsLoginDomain)
        for (var b in iapiConf) {
            var a = iapiConf[b];
            "string" === typeof a && 0 <= a.indexOf("http") && 0 < a.indexOf("$imsLoginDomain") && (a = a.replace("$imsLoginDomain", iapiConf.imsLoginDomain),
            iapiConf[b] = a)
        }
}
replaceImsDomain();
var iapiVersion = "_version_"
  , iapiERR_OK = 0
  , iapiERR_NOK = -1
  , iapiERR_BLOCKED = -2
  , iapiCALLOUT_LOGIN = "Login"
  , iapiCALLOUT_EMAILLOGIN = "EmailLogin"
  , iapiCALLOUT_TEMPORARYTOKEN = "GetTemporaryAuthenticationToken"
  , iapiCALLOUT_LOGINANDGETTEMPTOKEN = "LoginAndGetTempToken"
  , iapiCALLOUT_EMAILLOGINANDGETTEMPTOKEN = "EmailLoginAndGetTempToken"
  , iapiCALLOUT_SESSIONVALIDATION = "ValidateLoginSession"
  , iapiCALLOUT_MESSAGES = "GetWaitingMessages"
  , iapiCALLOUT_SUBMITDIALOG = "SubmitDialog"
  , iapiCALLOUT_FORGOTPASSWORD = "ForgotPassword"
  , iapiCALLOUT_STARTFORGOTEMAIL = "StartForgotEamil"
  , iapiCALLOUT_COMPLETEFORGOTEMAIL = "CompleteForgotEmail"
  , iapiCALLOUT_ONLINEFORGOTPASSWORD = "OnlineForgotPassword"
  , iapiCALLOUT_GETLOGGEDINPLAYER = "GetLoggedInPlayer"
  , iapiCALLOUT_KEEPALIVE = "KeepAlive"
  , iapiCALLOUT_LOGOUT = "Logout"
  , iapiCALLOUT_GETURLS = "GetUrls"
  , iapiCALLOUT_RESENDLOGIN2FATOKEN = "ResendLogin2FAToken"
  , iapiEVENT_TIMER = 10
  , STOCK_AUTH_PHONE_NUMBER = "pinAuth888"
  , iapiUsername = null
  , iapiPassword = null
  , iapiEmail = null
  , iapiAdminUsername = null
  , iapiRealMode = 1
  , iapiAuthenticationType = null
  , iapiDivname = "iapidiv"
  , iapiIframename = "iapiiframe"
  , iapiRealCookieIframe = "iapirealcookieiframe"
  , iapiFunCookieIframe = "iapifuncookieiframe"
  , iapiGetLoggedInPlayerRequestIdReal = 1234567890
  , iapiGetLoggedInPlayerRequestIdFun = 9876543210
  , iapiClientParams = []
  , iapiWaitingMessagesId = 0
  , iapiRememberMeLogin = null
  , iapiCalloutFunctions = []
  , iapiRequestIds = []
  , iapiLoginSuccess = !1
  , iapiSessionValid = 0
  , iapiNextLogin = null
  , iapiLoginModeDownload = !1
  , iapiLoginModeFlash = !1
  , iapiFlashLoginClientType = null
  , iapiFlashLoginGameType = null
  , iapiMessagesSupported = !1
  , iapiMessagesAnswered = !1
  , iapiLoginTypes = Object.freeze({
    SESSION_TOKEN: "sessionToken",
    CRYPTO_TOKEN: "cryptoToken",
    EXTERNAL_TOKEN: "externalToken",
    ADMIN_USERNAME: "adminUsername",
    NICKNAME: "nickname",
    EMAIL: "email",
    TOKEN_CODE: "tokenCode",
    PRINTED_TOKEN_CODE: "printedTokenCode",
    USERNAME_AND_PIN: "usernameAndPin",
    TOKEN_CODE_AND_PASS: "tokenCodeAndPass",
    PASSWORD: "password"
});
function iapiLogin(b, a, c, d, e) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiConf.authenticationType;
    iapiBaseLogin(b, a, c, d, e);
    return iapiERR_OK
}
function iapiEmailLogin(b, a, c, d, e) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.EMAIL;
    iapiBaseLogin(b, a, c, d, e);
    return iapiERR_OK
}
function iapiLoginExternalToken(b, a, c, d) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.EXTERNAL_TOKEN;
    iapiBaseLogin(null, b, a, c, d);
    return iapiERR_OK
}
function iapiLoginUsernameExternalToken(b, a, c, d, e) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.EXTERNAL_TOKEN;
    iapiBaseLogin(b, a, c, d, e);
    return iapiERR_OK
}
function iapiLoginAdminUsername(b, a, c, d, e) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.ADMIN_USERNAME;
    iapiAdminUsername = b;
    iapiBaseLogin(e, a, c, d);
    return iapiERR_OK
}
function iapiLoginSessionToken(b, a, c) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.SESSION_TOKEN;
    iapiBaseLogin(null, b, a, c);
    return iapiERR_OK
}
function iapiLoginCryptoToken(b, a) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.CRYPTO_TOKEN;
    iapiBaseLogin(null, b, 1, a);
    return iapiERR_OK
}
function iapiLoginNickname(b, a, c, d) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.NICKNAME;
    iapiBaseLogin(b, a, c, d);
    return iapiERR_OK
}
function iapiLoginIdTokenCodeAndPin(b, a, c, d) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.TOKEN_CODE;
    iapiBaseLogin(b, a, 1, c, d);
    return iapiERR_OK
}
function iapiLoginPrintedIdTokenCodeAndPin(b, a, c, d) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.PRINTED_TOKEN_CODE;
    iapiBaseLogin(b, a, 1, c, d);
    return iapiERR_OK
}
function iapiLoginUsernameAndPin(b, a, c, d) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.USERNAME_AND_PIN;
    iapiBaseLogin(b, a, 1, c, d);
    return iapiERR_OK
}
function iapiLoginIdTokenCodeAndPassword(b, a, c) {
    iapiLoginModeFlash = iapiLoginModeDownload = !1;
    iapiAuthenticationType = iapiLoginTypes.TOKEN_CODE_AND_PASS;
    iapiBaseLogin(b, a, 1, c);
    return iapiERR_OK
}
function iapiLaunchClient(b, a, c, d, e, f) {
    var g = iapiConf["clientUrl_" + b];
    if (g) {
        a && (g = iapiAddUrlParams(g, "game=" + a));
        c && (g = iapiAddUrlParams(g, "preferedmode=" + c));
        iapiClientParams["clientParams_" + b] && (g = iapiAddUrlParams(g, iapiClientParams["clientParams_" + b]));
        if (0 <= g.indexOf("$domain") || 0 <= g.indexOf("<domain>"))
            c = getCurrentDomain(),
            g = g.replace("$domain", c),
            g = g.replace("<domain>", c);
        if (iapiLoginModeFlash) {
            document.location = g;
            return
        }
        c = "width=800,height=600";
        if (void 0 != e && void 0 != f)
            if (-1 == e && -1 == f) {
                c = "";
                if ("Microsoft Internet Explorer" == navigator.appName || 0 <= navigator.userAgent.indexOf("Safari") && 0 > navigator.userAgent.indexOf("Chrome"))
                    c = "left=0,top=0,";
                a = screen.width;
                e = screen.height;
                void 0 != screen.availWidth && (a = screen.availWidth,
                e = screen.availHeight);
                "number" == typeof innerWidth && "number" == typeof outerWidth && (a -= outerWidth - innerWidth,
                e -= outerWidth - innerWidth);
                c += "width=" + a + ",height=" + e
            } else
                c = "width=" + e + ",height=" + f;
        else
            iapiConf["windowSize_" + b] && (a = iapiConf["windowSize_" + b][a],
            void 0 == a && (a = iapiConf["windowSize_" + b]["default"]),
            void 0 != a && iapiConf.windowSizes[a] && (c = iapiConf.windowSizes[a]));
        if (null != d && 0 < d.length) {
            if (a = document.getElementById(d))
                return a.src = g,
                iapiERR_OK
        } else
            d = "";
        a = "toolbar=no,menubar=no,scrollbars=no,resizable=no";
        iapiConf["windowParams_" + b] && (a = iapiConf["windowParams_" + b]);
        windowParams = c + "," + a;
        b = window.open(g, d, windowParams);
        return null == b || b.closed ? iapiERR_BLOCKED : iapiERR_OK
    }
    return iapiERR_NOK
}
function iapiSetClientParams(b, a) {
    iapiClientParams["clientParams_" + b] = a
}
function NoSystemId() {}
NoSystemId.prototype.toString = function() {
    return ""
}
;
var noSystemId = new NoSystemId;
function iapiRequestTemporaryToken(b, a, c, d, e) {
    var f = "GetTemporaryAuthenticationToken.php?casinoname=" + iapiConf.casinoname;
    f = void 0 != c ? f + ("&serviceType=" + c) : f + ("&serviceType=" + iapiConf.serviceType);
    0 === a || 0 === parseInt(a) ? a = void 0 : a ? (new String(a)).toString() || (a = void 0) : a = iapiConf.systemId;
    a && (f += "&systemId=" + a);
    d && (f += "&inheritance=" + d);
    void 0 != b && (f += "&realMode=" + b);
    void 0 != e && (f += "&label=" + e);
    iapiMakeRedirectRequest(f, null, iapiCALLOUT_TEMPORARYTOKEN);
    return iapiERR_OK
}
function iapiLoginAndGetTempToken(b, a, c, d, e, f, g, h) {
    iapiClearRedirectRequests(iapiCALLOUT_LOGINANDGETTEMPTOKEN, c);
    0 === e || 0 === parseInt(e) ? e = void 0 : e ? (new String(e)).toString() || (e = void 0) : e = iapiConf.systemId;
    f || (f = iapiConf.serviceType);
    d && iapiSetLanguageCode(d);
    c = "LoginAndGetTempToken.php?casinoname=" + iapiConf.casinoname + "&realMode=" + c + "&serviceType=" + f;
    e && (c += "&systemId=" + e);
    1 == g && (c += "&rememberMeLogin=1");
    h && (c += "&inheritance=" + h);
    g = [];
    iapiAuthenticationType = iapiConf.authenticationType;
    iapiAuthenticationType == iapiLoginTypes.EXTERNAL_TOKEN ? (b && (g.username = b),
    g.externalToken = a,
    iapiConf.italyAamsSessionCode && (g.italyAamsSessionCode = iapiConf.italyAamsSessionCode),
    iapiConf.italyParticipationCode && (g.italyParticipationCode = iapiConf.italyParticipationCode),
    iapiConf.italyExternalGameTableSessionCode && (g.italyExternalGameTableSessionCode = iapiConf.italyExternalGameTableSessionCode)) : iapiAuthenticationType == iapiLoginTypes.SESSION_TOKEN ? g.sessionToken = a : iapiAuthenticationType == iapiLoginTypes.ADMIN_USERNAME ? (b && (g.adminUsername = b),
    g.externalToken = a) : iapiAuthenticationType == iapiLoginTypes.NICKNAME ? (g.nickname = b,
    g.password = a,
    g.systemId = e) : iapiAuthenticationType == iapiLoginTypes.EMAIL ? (b && (g.email = b),
    g.password = a,
    iapiConf.iovationBlackbox && (g.iovationBlackbox = iapiConf.iovationBlackbox)) : (g.username = b,
    g.password = a,
    iapiConf.iovationBlackbox && (g.iovationBlackbox = iapiConf.iovationBlackbox),
    iapiConf.italyAamsSessionCode && (g.italyAamsSessionCode = iapiConf.italyAamsSessionCode),
    iapiConf.italyParticipationCode && (g.italyParticipationCode = iapiConf.italyParticipationCode),
    iapiConf.italyExternalGameTableSessionCode && (g.italyExternalGameTableSessionCode = iapiConf.italyExternalGameTableSessionCode));
    iapiAddClientHintsAndContinue(c, g, iapiCALLOUT_LOGINANDGETTEMPTOKEN);
    return iapiERR_OK
}
function iapiEmailLoginAndGetTempToken(b, a, c, d, e, f, g, h) {
    iapiConf.authenticationType = iapiLoginTypes.EMAIL;
    iapiLoginAndGetTempToken(b, a, c, d, e, f, g, h);
    iapiConf.authenticationType = null
}
function iapiLoginExternalTokenAndGetTempToken(b, a, c, d, e, f, g, h) {
    iapiConf.authenticationType = iapiLoginTypes.EXTERNAL_TOKEN;
    iapiLoginAndGetTempToken(b, a, c, d, e, f, g, h);
    iapiConf.authenticationType = null
}
function iapiDownloadLogin(b, a, c, d) {
    iapiAuthenticationType = null;
    iapiLoginModeDownload = !0;
    iapiLoginModeFlash = !1;
    iapiBaseLogin(b, a, c, d);
    return iapiERR_OK
}
function iapiDownloadEmailLogin(b, a, c, d) {
    iapiAuthenticationType = iapiLoginTypes.EMAIL;
    iapiLoginModeDownload = !0;
    iapiLoginModeFlash = !1;
    iapiBaseLogin(b, a, c, d);
    return iapiERR_OK
}
function iapiFlashLogin(b, a, c, d, e, f) {
    iapiAuthenticationType = null;
    iapiLoginModeFlash = !0;
    iapiLoginModeDownload = !1;
    iapiFlashLoginClientType = e;
    iapiFlashLoginGameType = f;
    iapiBaseLogin(b, a, c, d);
    return iapiERR_OK
}
function iapiFlashEmailLogin(b, a, c, d, e, f) {
    iapiAuthenticationType = iapiLoginTypes.EMAIL;
    iapiLoginModeFlash = !0;
    iapiLoginModeDownload = !1;
    iapiFlashLoginClientType = e;
    iapiFlashLoginGameType = f;
    iapiBaseLogin(b, a, c, d);
    return iapiERR_OK
}
function iapiLogout(b, a, c, d, e, f) {
    iapiEmail = iapiPassword = iapiUsername = null;
    iapiClearRedirectRequests(iapiCALLOUT_LOGIN, a);
    var g = [];
    1 == a ? iapiWriteClientCookie("loginSuccess=0&errorCode=0&expire=-1", 1) : iapiWriteClientCookie("loginSuccess=0&errorCode=0&expire=-1", 0);
    void 0 == c && (c = 1 == b ? "all" : "this");
    var h = "Logout.php?allSessions=" + b + "&casinoname=" + iapiConf.casinoname + "&behaviour=" + c;
    g.allSessions = b;
    g.casinoname = iapiConf.casinoname;
    g.behaviour = c;
    void 0 != a && (h += "&realMode=" + a,
    g.realMode = a);
    1 == d && (h += "&invalidateRememberMe=1",
    g.invalidateRememberMe = 1);
    void 0 != e && (h += "&supportedFeatures=" + encodeURIComponent(e),
    g.supportedFeatures = e);
    void 0 != f && (h += "&label=" + f,
    g.label = f);
    iapiConf.onlypostrequestsforlogout ? iapiMakeRedirectRequest(h, g, iapiCALLOUT_LOGOUT) : iapiMakeRedirectRequest(h, null, iapiCALLOUT_LOGOUT);
    return iapiERR_OK
}
function iapiSetCallout(b, a) {
    iapiCalloutFunctions[b] = a;
    return iapiERR_OK
}
function iapiGetWaitingMessages(b, a) {
    iapiClearRedirectRequests(iapiCALLOUT_MESSAGES, 0);
    iapiClearRedirectRequests(iapiCALLOUT_MESSAGES, 1);
    b || (b = "login,bonus,alert");
    iapiMakeRedirectRequest("GetWaitingMessages.php?messageTypes=" + b + "&casinoname=" + iapiConf.casinoname + "&realMode=" + a, null, iapiCALLOUT_MESSAGES);
    return iapiERR_OK
}
function iapiAcceptPendingLimits(b, a) {
    var c = "SubmitDialog.php?dialogType=AcceptPendingLimits&casinoname=" + iapiConf.casinoname;
    void 0 != a && (c += "&realMode=" + a);
    a = [];
    a.action = b;
    iapiMakeRedirectRequest(c, a, iapiCALLOUT_SUBMITDIALOG);
    return iapiERR_OK
}
function iapiBonusConfirmation(b, a, c) {
    var d = "SubmitDialog.php?dialogType=BonusConfirmation&casinoname=" + iapiConf.casinoname;
    void 0 != c && (d += "&realMode=" + c);
    c = [];
    c.bonusIdentifier = b;
    c.accept = a ? 1 : 0;
    iapiMakeRedirectRequest(d, c, iapiCALLOUT_SUBMITDIALOG);
    return iapiERR_OK
}
function iapiValidateTCVersion(b, a, c) {
    var d = "ValidateLoginSession.php?validationType=TCVersion&casinoname=" + iapiConf.casinoname;
    void 0 != c && (d += "&realMode=" + c);
    c = [];
    c.termVersionReference = b;
    c.accept = a ? 1 : 0;
    iapiMakeRedirectRequest(d, c, iapiCALLOUT_SESSIONVALIDATION);
    return iapiERR_OK
}
function iapiValidateGeolocation(b, a, c, d, e, f, g) {
    const h = [];
    h.latitude = b;
    h.longitude = a;
    h.geopacket = c;
    h.transactionId = d;
    h.error = e;
    h.geolocationType = f;
    h.metadata = g;
    for (let k in h)
        null !== h[k] && void 0 !== h[k] || delete h[k];
    iapiMakeRedirectRequest("ValidateLoginSession.php?validationType=Geolocation&casinoname=" + iapiConf.casinoname + "&realMode=1", h, iapiCALLOUT_SESSIONVALIDATION);
    return iapiERR_OK
}
function iapiValidatePasswordChange(b, a, c, d) {
    var e = "ValidateLoginSession.php?validationType=PasswordChange&casinoname=" + iapiConf.casinoname;
    void 0 != d && (e += "&realMode=" + d);
    d = [];
    d.oldPassword = b;
    d.newPassword = a;
    c && (d.changePassword = 1);
    iapiMakeRedirectRequest(e, d, iapiCALLOUT_SESSIONVALIDATION);
    return iapiERR_OK
}
function iapiValidateConfirmationToken(b, a) {
    var c = "ValidateLoginSession.php?validationType=ConfirmationToken&casinoname=" + iapiConf.casinoname;
    a && (c += "&realMode=" + a);
    a = [];
    a.parameter = b;
    iapiMakeRedirectRequest(c, a, iapiCALLOUT_SESSIONVALIDATION);
    return iapiERR_OK
}
function iapiValidateBirthdateToken(b, a) {
    var c = "ValidateLoginSession.php?validationType=Birthdate&casinoname=" + iapiConf.casinoname;
    a && (c += "&realMode=" + a);
    a = [];
    a.birthdate = b;
    iapiMakeRedirectRequest(c, a, iapiCALLOUT_SESSIONVALIDATION);
    return iapiERR_OK
}
function iapiValidateActivationCode(b, a) {
    var c = "ValidateLoginSession.php?validationType=ActivationCode&casinoname=" + iapiConf.casinoname;
    a && (c += "&realMode=" + a);
    a = [];
    a.activationCode = b;
    iapiMakeRedirectRequest(c, a, iapiCALLOUT_SESSIONVALIDATION);
    return iapiERR_OK
}
function iapiValidatePinChange(b, a) {
    var c = "ValidateLoginSession.php?validationType=PINChange&casinoname=" + iapiConf.casinoname + "&realMode=1"
      , d = [];
    d.oldPin = b;
    d.newPin = a;
    iapiMakeRedirectRequest(c, d, iapiCALLOUT_SESSIONVALIDATION)
}
function iapiValidatePinToken(b) {
    var a = "ValidateLoginSession.php?validationType=PINToken&casinoname=" + iapiConf.casinoname + "&realMode=1"
      , c = [];
    c.pin = b;
    iapiMakeRedirectRequest(a, c, iapiCALLOUT_SESSIONVALIDATION)
}
function iapiValidatePassword(b, a) {
    var c = "ValidateLoginSession.php?validationType=LoginNameAndPassword&casinoname=" + iapiConf.casinoname + "&realMode=1"
      , d = [];
    d.password = b;
    d.loginName = a;
    iapiMakeRedirectRequest(c, d, iapiCALLOUT_SESSIONVALIDATION)
}
function iapiValidateTwoFactorToken(b, a, c) {
    var d = "ValidateLoginSession.php?validationType=TwoFactor&casinoname=" + iapiConf.casinoname + "&realMode=1"
      , e = [];
    e["2faToken"] = b;
    e.trustDevice = a;
    e.deviceName = c;
    iapiMakeRedirectRequest(d, e, iapiCALLOUT_SESSIONVALIDATION)
}
function iapiValidateFitToPlayToken(b) {
    var a = "ValidateLoginSession.php?validationType=FitToPlay&casinoname=" + iapiConf.casinoname + "&realMode=1"
      , c = [];
    c.fitToPlay = b;
    iapiMakeRedirectRequest(a, c, iapiCALLOUT_SESSIONVALIDATION)
}
function iapiValidateMfaToken(b, a) {
    var c = "ValidateLoginSession.php?validationType=MFA&casinoname=" + iapiConf.casinoname + "&realMode=1"
      , d = [];
    d.mfaToken = b;
    d.transactionId = a;
    iapiMakeRedirectRequest(c, d, iapiCALLOUT_SESSIONVALIDATION)
}
function iapiForgotPassword(b, a, c, d, e, f, g) {
    d = "ForgotPassword.php?casinoname=" + iapiConf.casinoname + "&realMode=" + d;
    var h = [];
    h.username = b;
    h.email = a;
    h.birthDate = c;
    e && (h.verificationAnswer = e);
    f && (h.passwordRecoveryDestinationLink = f);
    g && (h.notificationChannels = g);
    iapiMakeRedirectRequest(d, h, iapiCALLOUT_FORGOTPASSWORD);
    return iapiERR_OK
}
function iapiStartForgotEmail(b, a, c, d, e) {
    c = "StartForgotEmail.php?casinoname=" + iapiConf.casinoname + "&realMode=" + c;
    var f = [];
    f.cellphone = b;
    f.birthdate = a;
    f.lastName = d;
    f.personalId = e;
    iapiMakeRedirectRequest(c, f, iapiCALLOUT_STARTFORGOTEMAIL);
    return iapiERR_OK
}
function iapiCompleteForgotEmail(b, a, c) {
    a = "CompleteForgotEmail.php?casinoname=" + iapiConf.casinoname + "&realMode=" + a;
    var d = [];
    d.token = b;
    c && (d.pin = c);
    iapiMakeRedirectRequest(a, d, iapiCALLOUT_COMPLETEFORGOTEMAIL);
    return iapiERR_OK
}
function iapiOnlineForgotPassword(b, a, c, d, e, f, g, h) {
    d = "OnlineForgotPassword.php?casinoname=" + iapiConf.casinoname + "&realMode=" + d;
    var k = [];
    k.username = b;
    a && (k.email = a);
    c && (k.birthDate = c);
    e && (k.verificationAnswer = e);
    f && (k.newPassword = f);
    g && (k.passwordRecoveryDestinationLink = g);
    h && (k.notificationChannels = h);
    iapiMakeRedirectRequest(d, k, iapiCALLOUT_ONLINEFORGOTPASSWORD);
    return iapiERR_OK
}
function iapiGetLoggedInPlayer(b) {
    var a = iapiCALLOUT_GETLOGGEDINPLAYER;
    if (isStorageAvailable()) {
        iapiCalloutFunctions[a = "loggedInPlayerHandlerX"] = self.loggedInPlayerHandlerX;
        let d = getSessionKey("loggedInPlayer-recent");
        var c = window.sessionStorage.getItem(d);
        if (c && (c = JSON.parse(c)) && Date.now() - c.time < (iapiConf.loggedInExpiry ? parseInt(iapiConf.loggedInExpiry) : 26E4) && (c.session == window.sessionStorage.getItem(getSessionKey("token")) || c.session == window.sessionStorage.getItem(getSessionKey("sessionRef"))))
            return setTimeout(function() {
                iapiCalloutFunctions[iapiCALLOUT_GETLOGGEDINPLAYER](c.resp)
            }, iapiEVENT_TIMER),
            iapiERR_OK;
        window.sessionStorage.removeItem(d)
    }
    iapiMakeRedirectRequest("GetLoggedInPlayer.php?casinoname=" + iapiConf.casinoname + "&realMode=" + b, null, a);
    return iapiERR_OK
}
function getSessionKey(b) {
    return "pas[" + iapiConf.casinoname + "][real][" + b + "]"
}
function loggedInPlayerHandlerX(b) {
    if (isStorageAvailable()) {
        let c = getSessionKey("loggedInPlayer-recent");
        if (b.username) {
            var a = {};
            a.resp = b;
            a.time = Date.now();
            a.session = window.sessionStorage.getItem(getSessionKey("token"));
            a.session || (a.session = window.sessionStorage.getItem(getSessionKey("sessionRef")));
            a = JSON.stringify(a);
            window.sessionStorage.setItem(c, a)
        } else
            window.sessionStorage.removeItem(c)
    }
    if (iapiCalloutFunctions[iapiCALLOUT_GETLOGGEDINPLAYER])
        iapiCalloutFunctions[iapiCALLOUT_GETLOGGEDINPLAYER](b)
}
function iapiKeepAlive(b, a) {
    b = "KeepAlive.php?casinoname=" + iapiConf.casinoname + "&realMode=" + b;
    a && (b += "&millisFromLastAction=" + a);
    iapiMakeRedirectRequest(b, null, iapiCALLOUT_KEEPALIVE);
    return iapiERR_OK
}
function iapiGetUrls(b) {
    iapiMakeRedirectRequest("GetUrls.php?casinoname=" + iapiConf.casinoname + "&realMode=1&urlTypeList=" + b, null, iapiCALLOUT_GETURLS);
    return iapiERR_OK
}
function iapiResendLogin2FAToken() {
    iapiMakeRedirectRequest("ResendLogin2FAToken?casinoname=" + iapiConf.casinoname, null, iapiCALLOUT_RESENDLOGIN2FATOKEN);
    return iapiERR_OK
}
function iapiSetAuthenticationType(b) {
    iapiConf.authenticationType = b
}
function iapiSetClientSkin(b) {
    iapiConf.clientSkin = b
}
function iapiSetClientType(b) {
    iapiConf.clientType = b
}
function iapiSetClientUrl(b, a) {
    iapiConf["clientUrl_" + b] = a
}
function iapiSetClientVersion(b) {
    iapiConf.clientVersion = b
}
function iapiSetClientChannel(b) {
    iapiConf.clientChannel = b
}
function iapiSetGameType(b) {
    iapiConf.gameType = b
}
function iapiSetGameTypePrefix(b) {
    iapiConf.gameTypePrefix = b
}
function iapiSetLaunchAlias(b) {
    iapiConf.launchAlias = b
}
function iapiSetClientPlatform(b) {
    iapiConf.clientPlatform = b
}
function iapiSetSystemId(b) {
    iapiConf.systemId = b
}
function iapiSetServiceType(b) {
    iapiConf.serviceType = b
}
function iapiSetLanguageCode(b) {
    iapiConf.languageCode = b
}
function iapiSetCallId(b) {
    iapiConf.callId = b
}
function iapiSetDeliveryPlatform(b) {
    iapiConf.deliveryPlatform = b
}
function iapiSetDeviceBrowser(b) {
    iapiConf.deviceBrowser = b
}
function iapiSetOsName(b) {
    iapiConf.osName = b
}
function iapiSetOsVersion(b) {
    iapiConf.osVersion = b
}
function iapiSetDeviceId(b) {
    iapiConf.deviceId = b
}
function iapiSetDeviceType(b) {
    iapiConf.deviceType = b
}
function iapiSetDeviceFamily(b) {
    iapiConf.deviceFamily = b
}
function iapiSetSoftSerial(b) {
    iapiConf.softSerial = b
}
function iapiSetIovationBlackbox(b) {
    iapiConf.iovationBlackbox = b
}
function iapiSetItalyAamsSessionCode(b) {
    iapiConf.italyAamsSessionCode = b
}
function iapiSetItalyParticipationCode(b) {
    iapiConf.italyParticipationCode = b
}
function iapiSetItalyExternalGameTableSessionCode(b) {
    iapiConf.italyExternalGameTableSessionCode = b
}
function iapiEnableUserErrors() {
    iapiConf.errorLevel = 1
}
function iapiGetGoogleLoginUri() {
    return getHttpProtocol() + "://" + iapiConf.loginServer + "/RedirectExternal/" + iapiConf.casinoname + "/Google"
}
function iapiGetGoogleClientId() {
    return iapiConf.googleClientId
}
function iapiCallbackWaitingMessages(b) {
    var a = iapiGetRequest(iapiWaitingMessagesId);
    if (a) {
        var c = {
            errorCode: 6,
            errorText: "Invalid response.",
            playerMessage: ""
        };
        b ? c = b.errorCode ? {
            errorCode: b.errorCode,
            errorText: b.errorText,
            playerMessage: b.playerMessage
        } : null : b = c;
        a = a.request;
        if (c && 6 == c.errorCode && a[3].length < iapiConf.loginDomainRetryCount) {
            c = (new Date).getTime() + Math.round(1E6 * Math.random());
            var d = setTimeout("iapiRequestFailed(" + c + ")", 1E3 * iapiConf.loginDomainRetryInterval);
            iapiRegisterRequestId(c, iapiCALLOUT_MESSAGES, d, a[3], a[4], a[5])
        } else
            iapiCalloutFunctions[iapiCALLOUT_MESSAGES] && setTimeout(function() {
                iapiCalloutFunctions[iapiCALLOUT_MESSAGES](b)
            }, iapiEVENT_TIMER)
    }
}
function iapiBaseLogin(b, a, c, d, e) {
    if (iapiHasRedirectRequest(iapiCALLOUT_LOGIN) && iapiRealMode != c)
        return iapiNextLogin = [b, a, c, d, e],
        iapiERR_OK;
    iapiAuthenticationType == iapiLoginTypes.EMAIL ? iapiEmail = b : iapiUsername = b;
    iapiPassword = a;
    iapiRealMode = 1 == c ? 1 : 0;
    d && iapiSetLanguageCode(d);
    iapiRememberMeLogin = e;
    iapiLoginSuccess = !1;
    iapiWriteClientCookie("loginInProgress=1", iapiRealMode);
    iapiContinueLogin()
}
function iapiContinueLogin() {
    iapiClearRedirectRequests(iapiCALLOUT_LOGIN, 0);
    iapiClearRedirectRequests(iapiCALLOUT_LOGIN, 1);
    var b = "Login.php?casinoname=" + iapiConf.casinoname;
    b = 1 == iapiRealMode ? b + "&realMode=1" : b + "&realMode=0";
    1 == iapiRememberMeLogin && (b += "&rememberMeLogin=1");
    var a = [];
    iapiAuthenticationType == iapiLoginTypes.EXTERNAL_TOKEN ? (iapiUsername && (a.username = iapiUsername),
    a.externalToken = iapiPassword,
    iapiConf.italyAamsSessionCode && (a.italyAamsSessionCode = iapiConf.italyAamsSessionCode),
    iapiConf.italyParticipationCode && (a.italyParticipationCode = iapiConf.italyParticipationCode),
    iapiConf.italyExternalGameTableSessionCode && (a.italyExternalGameTableSessionCode = iapiConf.italyExternalGameTableSessionCode)) : iapiAuthenticationType == iapiLoginTypes.EMAIL ? (iapiEmail && (a.email = iapiEmail),
    a.password = iapiPassword,
    iapiConf.iovationBlackbox && (a.iovationBlackbox = iapiConf.iovationBlackbox)) : iapiAuthenticationType == iapiLoginTypes.SESSION_TOKEN ? a.sessionToken = iapiPassword : iapiAuthenticationType == iapiLoginTypes.CRYPTO_TOKEN ? a.cryptoToken = iapiPassword : iapiAuthenticationType == iapiLoginTypes.ADMIN_USERNAME ? (iapiAdminUsername && (a.adminUsername = iapiAdminUsername),
    a.username = iapiUsername,
    a.externalToken = iapiPassword) : iapiAuthenticationType == iapiLoginTypes.NICKNAME ? (a.nickname = iapiUsername,
    a.password = iapiPassword,
    a.systemId = iapiConf.systemId) : iapiAuthenticationType == iapiLoginTypes.TOKEN_CODE ? (a.tokenCode = iapiUsername,
    a.pin = iapiPassword,
    a.systemId = iapiConf.systemId) : iapiAuthenticationType == iapiLoginTypes.PRINTED_TOKEN_CODE ? (a.printedTokenCode = iapiUsername,
    a.pin = iapiPassword,
    a.systemId = iapiConf.systemId) : iapiAuthenticationType == iapiLoginTypes.USERNAME_AND_PIN ? (a.username = iapiUsername,
    a.phone = STOCK_AUTH_PHONE_NUMBER,
    a.pin = iapiPassword,
    a.systemId = iapiConf.systemId) : iapiAuthenticationType == iapiLoginTypes.TOKEN_CODE_AND_PASS ? (a.tokenCode = iapiUsername,
    a.password = iapiPassword,
    a.systemId = iapiConf.systemId) : (a.username = iapiUsername,
    a.password = iapiPassword,
    iapiConf.iovationBlackbox && (a.iovationBlackbox = iapiConf.iovationBlackbox),
    iapiConf.italyAamsSessionCode && (a.italyAamsSessionCode = iapiConf.italyAamsSessionCode),
    iapiConf.italyParticipationCode && (a.italyParticipationCode = iapiConf.italyParticipationCode),
    iapiConf.italyExternalGameTableSessionCode && (a.italyExternalGameTableSessionCode = iapiConf.italyExternalGameTableSessionCode));
    iapiAddClientHintsAndContinue(b, a, iapiCALLOUT_LOGIN);
    return iapiERR_OK
}
function iapiAddClientHintsAndContinue(b, a, c) {
    if (isDeviceAtlasEnabled())
        try {
            Promise.race([Promise.all([clientHints().clientHintHeaders, deviceAtlasLoaded]), new Promise(function(d, e) {
                setTimeout(e, 200)
            }
            )]).then(function(d) {
                const [e,f] = d;
                a.clientHints = JSON.stringify(e);
                f && "function" === typeof DeviceAtlas.getPropertiesAsString && (a.deviceAtlasProperties = DeviceAtlas.getPropertiesAsString());
                iapiMakeRedirectRequest(b, a, c)
            }, function() {
                iapiMakeRedirectRequest(b, a, c)
            })
        } catch (d) {
            iapiMakeRedirectRequest(b, a, c)
        }
    else
        iapiMakeRedirectRequest(b, a, c)
}
function iapiWriteClientCookie(b, a) {
    if (!iapiLoginModeDownload) {
        var c = iapiConf.clientCookieUrl;
        c && (0 > c.indexOf("://") && (c = location.protocol + "//" + c),
        b = c + "?" + b + "&casinoname=" + iapiConf.casinoname + "&realMode=" + a,
        c = iapiRealCookieIframe,
        0 == a && (c = iapiFunCookieIframe),
        iapiCreateDiv(iapiDivname),
        iapiCreateIframe(iapiDivname, c, "weLoveBaking"),
        iapiGet(c, b))
    }
}
function iapiCreateDiv(b) {
    if (!document.getElementById(b)) {
        var a = document.createElement("div");
        a.setAttribute("id", b);
        a.setAttribute("style", "DISPLAY:none;");
        document.body.appendChild(a)
    }
}
function resolveFrameName(b, a, c) {
    return c == iapiCALLOUT_GETLOGGEDINPLAYER || "loggedInPlayerHandlerX" == c ? b + "-" + c : a
}
function iapiCreateIframe(b, a, c) {
    let d = document.getElementById(b)
      , e = c == iapiCALLOUT_GETLOGGEDINPLAYER || "loggedInPlayerHandlerX" == c;
    a = resolveFrameName(b, a, c);
    if (document.getElementById(a)) {
        if (e)
            return a;
        d.removeChild(document.getElementById(a))
    }
    try {
        var f = document.createElement("<iframe name='" + a + "'>")
    } catch (g) {
        f = document.createElement("iframe")
    }
    e && (f.dataset.reusable = c);
    f.setAttribute("id", a);
    f.setAttribute("name", a);
    f.setAttribute("style", "DISPLAY: none; LEFT: 0px; POSITION: absolute; TOP: 0px");
    f.setAttribute("width", "0px");
    f.setAttribute("height", "0px");
    f.setAttribute("border", "0px");
    f.setAttribute("frameborder", "0");
    d.appendChild(f);
    return null
}
function iapiPost(b, a, c) {
    b = encodeHTML(b);
    a = encodeURL(a);
    a = "<html><head></head><body><form id='formid' target='" + b + "' method='POST' action='" + a + "'>";
    for (var d in c)
        "function" != typeof c[d] && (a += "<input type='hidden' name='" + d + "' value='" + encodeHTML(c[d]) + "'>");
    iapiPostWindow(b, a + "</form><script type='text/javascript'>setTimeout(function(){document.getElementById('formid').submit();},100);\x3c/script></body></html>")
}
function iapiPostWindow(b, a) {
    if (b = document.getElementById(b))
        try {
            b.contentWindow.document.open(),
            b.contentWindow.document.write(a),
            b.contentWindow.document.close()
        } catch (c) {
            a = "javascript:'<script>window.onload=function(){var ed=\\'" + escape(escape("<script>document.domain='" + document.domain + "';\x3c/script>" + a)) + "\\';document.write(unescape(ed));document.close();};\x3c/script>'",
            b.src = a
        }
}
function iapiMakeRedirectRequest(b, a, c, d) {
    if (!d)
        d = [];
    else if (d.length >= iapiConf.loginDomainRetryCount || 25 <= d.length)
        return !1;
    var e = iapiConf.loginServer.split("|");
    if (d.length < e.length)
        for (var f in d) {
            var g = d[f], h;
            for (h in e)
                if (e[h] == g && "string" === typeof e[h]) {
                    e.splice(h, 1);
                    break
                }
        }
    b = iapiAppendContextParameters(b);
    var k = e[Math.floor(Math.random() * e.length)];
    d.push(k);
    requestUrl = getHttpProtocol() + "://" + k + "/" + b;
    let l = Date.now() + "x" + Math.round(1E6 * Math.random());
    requestUrl = isPostMessagesDisabled() && c == iapiCALLOUT_MESSAGES ? requestUrl + ("&cacheBreaker=" + (new Date).getTime()) : requestUrl + ("&redirectUrl=" + encodeURIComponent(location.protocol + "//" + location.hostname + (location.port ? ":" + location.port : "") + (iapiConf.redirectUrl ? iapiConf.redirectUrl : "/") + "#requestId=" + l));
    1 == iapiConf.errorLevel && (requestUrl += "&errorLevel=1");
    e = setTimeout(function() {
        iapiRequestFailed(l)
    }, 1E3 * iapiConf.loginDomainRequestTimeout);
    iapiRegisterRequestId(l, c, e, d, b, a);
    self.pasLogin && self.pasLogin.removeCallbackFromPostParams && (a = self.pasLogin.removeCallbackFromPostParams(a));
    if (isPostMessagesDisabled() && c == iapiCALLOUT_MESSAGES)
        iapiWaitingMessagesId = l,
        iapiJsonp(requestUrl, "iapiCallbackWaitingMessages");
    else {
        iapiCreateDiv(iapiDivname);
        d = resolveFrameName(iapiDivname, iapiIframename + "_" + l, c);
        (b = iapiCreateIframe(iapiDivname, d, c)) && (d = b);
        var m = document.getElementById(d);
        m.dataset.requestId = l;
        iapiMessagesSupported || initMessageListener();
        if (isPostMessagesDisabled()) {
            if (iapiMessagesSupported && (requestUrl += "&messagesSupported=1",
            b && iapiMessagesAnswered && m.contentWindow.postMessage))
                return m.contentWindow.postMessage(c, getHttpProtocol() + "://" + k),
                !0
        } else if (iapiMessagesSupported) {
            requestUrl += "&messagesSupported=1";
            if (Array.isArray(a) && 0 == a.length && 0 < Object.keys(a).length && isHashPropertyUsed()) {
                d = a;
                e = ["object", "string", "number", "boolean"];
                a = {};
                for (var p in d)
                    f = d[p],
                    0 <= e.indexOf(typeof f) && (a[p] = f)
            }
            var n = {
                requestType: c,
                postParams: a,
                url: requestUrl,
                casino: iapiConf.casinoname,
                requestId: l,
                loginServer: getHttpProtocol() + "://" + k
            };
            b ? m.contentWindow.postMessage(n, getHttpProtocol() + "://" + k) : (a = getHttpProtocol() + "://" + k + "/pasSetupPage.php?casino=" + iapiConf.casinoname,
            isHashPropertyUsed() && (a = a + "#" + encodeURIComponent(JSON.stringify(n))),
            m.contentWindow.location.replace(a),
            isHashPropertyUsed() || m.addEventListener("load", function(q) {
                m.contentWindow.postMessage(n, getHttpProtocol() + "://" + k)
            }));
            return
        }
        a ? iapiPost(d, requestUrl, a) : iapiGet(d, requestUrl)
    }
    return !0
}
function isHashPropertyUsed() {
    return 0 != iapiConf.useHashProperty
}
var storageAvailableResolved = 0;
function isStorageAvailable() {
    if (storageAvailableResolved)
        return 0 < storageAvailableResolved;
    try {
        return window.sessionStorage.setItem("test", "test"),
        window.sessionStorage.removeItem("test"),
        checkCookieBuster(),
        0 < (storageAvailableResolved = 1)
    } catch (b) {}
    return 0 < (storageAvailableResolved = -1)
}
function checkCookieBuster() {
    try {
        if (!(0 > storageAvailableResolved) && window.sessionStorage) {
            var b = cookieBusterValue();
            b && b != window.sessionStorage.getItem("pasCookieBuster") && (clearSessionStorage(window.sessionStorage),
            window.sessionStorage.setItem("pasCookieBuster", b))
        }
    } catch (a) {
        storageAvailableResolved = -1
    }
}
function clearSessionStorage(b) {
    let a = Object.keys(b);
    for (var c in a)
        a[c].startsWith("pas[") && b.removeItem(a[c])
}
function cookieBusterValue() {
    let b = document.cookie.split(";");
    for (var a in b)
        if (b[a].trim().startsWith("pasCookieBuster="))
            return b[a].split("=")[1];
    return ""
}
function isPostMessagesDisabled() {
    return 1 == iapiConf.postMessagesDisabled
}
function iapiAppendContextParameters(b) {
    iapiConf = iapiConf || [];
    iapiLoginModeDownload ? iapiConf.clientPlatform = "download" : iapiConf.clientPlatform || (iapiConf.clientPlatform = "flash");
    for (var a = "clientType clientPlatform clientVersion clientSkin clientChannel callId gameType gameTypePrefix softSerial deviceId deliveryPlatform deviceType osName osVersion deviceBrowser languageCode deviceFamily launchAlias".split(" "), c = 0; c < a.length; c++) {
        var d = a[c];
        iapiConf[d] && (b = iapiAddUrlParams(b, d + "=" + iapiConf[d]))
    }
    return b
}
function iapiJsonp(b, a) {
    var c = document.createElement("SCRIPT");
    c.type = "text/javascript";
    c.src = encodeURL(b) + "&jsoncallback=" + a + "&responseType=json";
    document.getElementsByTagName("HEAD")[0].appendChild(c)
}
function iapiGet(b, a) {
    if (b = document.getElementById(b))
        b.src = encodeURL(a)
}
function iapiAddUrlParams(b, a) {
    b = 0 < b.indexOf("?") ? b + "&" : b + "?";
    return b + a
}
function iapiLoginFailedActions(b) {
    iapiPassword = null;
    iapiLoginSuccess = !1;
    iapiSessionValid = 0;
    var a = b.errorCode;
    iapiWriteClientCookie("loginSuccess=0&errorCode=" + a, iapiRealMode);
    iapiCalloutFunctions.login && setTimeout(function() {
        iapiCalloutFunctions.login(0, 0, a, iapiRealMode)
    }, iapiEVENT_TIMER);
    iapiCalloutFunctions[iapiCALLOUT_LOGIN] && setTimeout(function() {
        iapiCalloutFunctions[iapiCALLOUT_LOGIN](b)
    }, iapiEVENT_TIMER);
    iapiLoginModeDownload && iapiDownloadHtcmd(0, 0, a, "");
    iapiCheckNextLogin()
}
function iapiTokenFailedActions(b) {
    iapiCalloutFunctions.temporarytoken && setTimeout(function() {
        iapiCalloutFunctions.temporarytoken(0, null)
    }, iapiEVENT_TIMER);
    iapiCalloutFunctions[iapiCALLOUT_TEMPORARYTOKEN] && setTimeout(function() {
        iapiCalloutFunctions[iapiCALLOUT_TEMPORARYTOKEN](b)
    }, iapiEVENT_TIMER);
    iapiLoginModeDownload && iapiDownloadHtcmd(1, iapiSessionValid, 0, "")
}
function iapiCheckNextLogin() {
    if (null != iapiNextLogin) {
        var b = iapiNextLogin[0]
          , a = iapiNextLogin[1]
          , c = iapiNextLogin[2]
          , d = iapiNextLogin[3]
          , e = iapiNextLogin[4];
        iapiNextLogin = null;
        setTimeout(function() {
            iapiLogin(b, a, c, d, e)
        }, iapiEVENT_TIMER)
    }
}
function iapiDownloadHtcmd(b, a, c, d) {
    b && d && (b = "htcmd:login?username=" + encodeURIComponent(iapiUsername),
    b = b + "&password=" + encodeURIComponent(d),
    b = b + "&realmode=" + iapiRealMode,
    document.location = b + "&type=3")
}
function iapiRedirectCallback(b, a) {
    var c = iapiGetRequest(b);
    if (c) {
        a && a.sessionRef && isStorageAvailable() && window.sessionStorage.setItem(getSessionKey("sessionRef"), a.sessionRef);
        var d = {
            errorCode: 6,
            errorText: "Invalid response.",
            playerMessage: ""
        };
        a ? d = a.errorCode ? {
            errorCode: a.errorCode,
            errorText: a.errorText,
            playerMessage: a.playerMessage
        } : null : a = d;
        b = c.request;
        var e = b[1];
        if (d && 6 == d.errorCode && b[3].length < iapiConf.loginDomainRetryCount) {
            var f = (new Date).getTime() + Math.round(1E6 * Math.random());
            c = setTimeout("iapiRequestFailed(" + f + ")", 1E3 * iapiConf.loginDomainRetryInterval);
            iapiRegisterRequestId(f, e, c, b[3], b[4], b[5])
        } else if (!(self.pasLogin && self.pasLogin.handleResponse && self.pasLogin.handleResponse(c, a)))
            if (e == iapiCALLOUT_LOGIN)
                if (null == d) {
                    iapiPassword = null;
                    iapiLoginSuccess = !0;
                    iapiSessionValid = 1;
                    if (b = a.sessionValidationData)
                        for (f in Object.keys(b))
                            if ("SessionValidationByGeolocationData" !== b[f]) {
                                iapiSessionValid = 0;
                                break
                            }
                    iapiWriteClientCookie("loginSuccess=1&sessionValid=" + iapiSessionValid + "&loginDomain=" + iapiConf.loginServer, iapiRealMode);
                    iapiCalloutFunctions.login && setTimeout(function() {
                        iapiCalloutFunctions.login(1, iapiSessionValid, 0, iapiRealMode)
                    }, iapiEVENT_TIMER);
                    iapiCalloutFunctions[iapiCALLOUT_LOGIN] && setTimeout(function() {
                        iapiCalloutFunctions[iapiCALLOUT_LOGIN](a)
                    }, iapiEVENT_TIMER);
                    iapiLoginModeDownload ? iapiSessionValid ? iapiRequestTemporaryToken(iapiRealMode) : iapiDownloadHtcmd(1, 0, 0, "") : iapiLoginModeFlash && iapiSessionValid && (b = "real",
                    iapiRealMode || (b = "fun"),
                    iapiLaunchClient(iapiFlashLoginClientType, iapiFlashLoginGameType, b));
                    iapiCheckNextLogin()
                } else
                    iapiLoginFailedActions(a);
            else
                e == iapiCALLOUT_TEMPORARYTOKEN ? null == d && a.sessionToken && a.sessionToken.sessionToken ? (iapiCalloutFunctions.temporarytoken && setTimeout(function() {
                    iapiCalloutFunctions.temporarytoken(1, a.sessionToken.sessionToken)
                }, iapiEVENT_TIMER),
                iapiCalloutFunctions[iapiCALLOUT_TEMPORARYTOKEN] && setTimeout(function() {
                    iapiCalloutFunctions[iapiCALLOUT_TEMPORARYTOKEN](a)
                }, iapiEVENT_TIMER),
                iapiLoginModeDownload && iapiDownloadHtcmd(1, 1, 0, a.sessionToken.sessionToken)) : iapiTokenFailedActions(a) : iapiCalloutFunctions[e] && setTimeout(function() {
                    iapiCalloutFunctions[e](a)
                }, iapiEVENT_TIMER)
    }
}
function iapiRequestFailed(b) {
    if (b = iapiGetRequest(b)) {
        var a = b.request
          , c = a[1];
        if (!iapiMakeRedirectRequest(a[4], a[5], c, a[3])) {
            var d = {
                errorCode: 6,
                errorText: "Request timed out.",
                playerMessage: ""
            };
            self.pasLogin && self.pasLogin.handleResponse && self.pasLogin.handleResponse(b, d) || (c == iapiCALLOUT_LOGIN ? iapiCalloutFunctions[iapiCALLOUT_LOGIN] && iapiLoginFailedActions(d) : c == iapiCALLOUT_TEMPORARYTOKEN ? iapiCalloutFunctions[iapiCALLOUT_TEMPORARYTOKEN] && iapiTokenFailedActions(d) : iapiCalloutFunctions[c] && setTimeout(function() {
                iapiCalloutFunctions[c](d)
            }, iapiEVENT_TIMER))
        }
    }
}
function iapiRegisterRequestId(b, a, c, d, e, f) {
    b = {
        request: [b, a, c, d, e, f]
    };
    iapiRequestIds.push(b);
    self.pasLogin && self.pasLogin.registerCallback && f && f.iapiCallback && self.pasLogin.registerCallback(b, f.iapiCallback)
}
function iapiGetRequest(b) {
    for (var a in iapiRequestIds) {
        var c = iapiRequestIds[a]
          , d = c.request;
        if (d[0] == b)
            return iapiRequestIds.splice(a, 1),
            d[2] && clearTimeout(d[2]),
            (b = document.getElementById(iapiIframename + "_" + b)) && !b.dataset.reusable && document.getElementById(iapiDivname).removeChild(b),
            c
    }
    return null
}
function iapiClearRedirectRequests(b, a) {
    for (var c = 0; c < iapiRequestIds.length; ) {
        var d = iapiRequestIds[c].request;
        if (d[1] == b) {
            var e = 0;
            0 < d[4].indexOf("realMode=1") && (e = 1);
            if (e == a) {
                iapiRequestIds.splice(c, 1);
                d[2] && clearTimeout(d[2]);
                (d = document.getElementById(iapiIframename + "_" + d[0])) && document.getElementById(iapiDivname).removeChild(d);
                continue
            }
        }
        c++
    }
}
function iapiHasRedirectRequest(b) {
    for (var a = 0; a < iapiRequestIds.length; ) {
        if (iapiRequestIds[a].request[1] == b)
            return !0;
        a++
    }
    return !1
}
function initMessageListener() {
    window.addEventListener("message", iapiOnMessage, !1);
    iapiMessagesSupported = !0
}
function iapiOnMessage(b) {
    if (b.origin) {
        var a = iapiConf.loginServer.split("|")
          , c = b.origin.replace(getHttpProtocol() + "://", "");
        c = a.indexOf(c);
        if (b.origin === getHttpProtocol() + "://" + a[c] && b.data && "string" === typeof b.data) {
            a = new URLSearchParams(b.data);
            try {
                var d = JSON.parse(a.get("redirectResponse"))
            } catch (f) {}
            if (d)
                var e = d.requestId;
            if (!e && (a = document.getElementById(iapiDivname)))
                for (c = 0; c < a.childNodes.length && 1E3 > c; c++)
                    if (a.childNodes[c].contentWindow == b.source) {
                        if (b = a.childNodes[c].dataset.requestId) {
                            e = b;
                            break
                        }
                        b = a.childNodes[c].id.split("_");
                        1 < b.length && (e = b[1]);
                        break
                    }
            iapiMessagesAnswered = !0;
            iapiRedirectCallback(e, d)
        }
    }
}
function iapiGetCookie(b) {
    b += "=";
    for (var a = document.cookie.split(";"), c = 0; c < a.length; c++) {
        for (var d = a[c]; " " == d.charAt(0); )
            d = d.substring(1);
        if (0 == d.indexOf(b))
            return d.substring(b.length, d.length)
    }
    return ""
}
function encodeHTML(b) {
    var a = document.createElement("div");
    b = document.createTextNode(b);
    a.appendChild(b);
    return a.innerHTML.replace(/'/g, "&#39;")
}
function encodeURL(b) {
    b = JSON.stringify(b);
    b = b.substring(1, b.length - 1);
    b = removeHex(b);
    return b.match(/^http/gi) ? b.replace(/</g, "%3C").replace(/>/g, "%3E").replace(/"/g, "%22").replace(/'/g, "%27") : ""
}
function removeHex(b) {
    return b.replace(/&#(\d+);/g, "").replace(/&#x([A-Za-z0-9]+);/g, "")
}
Array.prototype.indexOf || (Array.prototype.indexOf = function(b, a) {
    if (null == this)
        throw new TypeError('"this" is null or not defined');
    var c = Object(this)
      , d = c.length >>> 0;
    if (0 === d)
        return -1;
    a = +a || 0;
    Infinity === Math.abs(a) && (a = 0);
    if (a >= d)
        return -1;
    for (a = Math.max(0 <= a ? a : d - Math.abs(a), 0); a < d; ) {
        if (a in c && c[a] === b)
            return a;
        a++
    }
    return -1
}
);
function getCurrentDomain() {
    if (self.$currentDomain)
        return self.$currentDomain;
    for (var b = 0, a = document.domain, c = a.split("."), d = "_gd" + (new Date).getTime(); b < c.length - 1 && -1 == document.cookie.indexOf(d + "=" + d); )
        a = c.slice(-1 - ++b).join("."),
        document.cookie = d + "=" + d + ";domain=" + a + ";";
    document.cookie = d + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;domain=" + a + ";";
    return self.$currentDomain = a
}
"undefined" !== typeof iapiJsLoaded && iapiJsLoaded();
function isSecureAttr() {
    return "false" == iapiConf.setSecureAttr ? !1 : !0
}
function getHttpProtocol() {
    return isSecureAttr() ? "https" : "http"
}
function isDeviceAtlasEnabled() {
    return !iapiConf.disableDeviceAtlasIntegration
}
var DeviceAtlas = {
    cacheType: "none",
    waitMilliSecondsToBulkSendProperties: 1E3
};
function shouldRunDeviceAtlas() {
    return -1 !== navigator.userAgent.toLowerCase().search(/iphone|ipad/)
}
function loadDeviceAtlasIfEnabled() {
    return isDeviceAtlasEnabled() && shouldRunDeviceAtlas() ? loadJsWrapperScript("dacs.js?v=2.7.3").catch(function() {}) : Promise.resolve(!1)
}
var deviceAtlasLoaded = loadDeviceAtlasIfEnabled();
function loadJsWrapperScript(b) {
    return new Promise(function(a) {
        const c = document.createElement("script");
        c.src = getHttpProtocol() + "://" + iapiConf.loginServer + "/jswrapper/" + b;
        c.type = "text/javascript";
        c.defer = !0;
        c.onerror = function(d) {
            a(!1)
        }
        ;
        c.onload = function() {
            a(!0)
        }
        ;
        window.document.head.appendChild(c)
    }
    )
}
function clientHints() {
    function b(d) {
        return d.map(function(e) {
            return '"' + a(e.brand) + '";v="' + e.version + '"'
        }).join(", ")
    }
    function a(d) {
        "string" === typeof d && d && (d = d.replace(/\\/, "\\\\").replace(/"/g, '\\"'));
        return d
    }
    function c(d) {
        return void 0 !== d && null !== d && "" !== d ? '"' + a(d) + '"' : d
    }
    return {
        clientHintHeaders: new Promise(function(d, e) {
            (e = navigator && navigator.userAgentData) && e.getHighEntropyValues ? e.getHighEntropyValues(["model", "platform", "platformVersion", "fullVersionList"]).then(function(f) {
                var g = c(f.model)
                  , h = c(f.platform)
                  , k = c(f.platformVersion);
                var l = f.fullVersionList;
                f = f.brands;
                l = Array.isArray(l) ? b(l) : Array.isArray(f) ? b(f) : void 0;
                d({
                    "Sec-CH-UA-Model": g,
                    "Sec-CH-UA-Platform": h,
                    "Sec-CH-UA-Platform-Version": k,
                    "Sec-CH-UA-Full-Version-List": l
                })
            }) : d(!1)
        }
        )
    }
}
;
