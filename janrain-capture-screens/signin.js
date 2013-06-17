function janrainCaptureWidgetOnLoad() {
	janrain.events.onCaptureAccessDenied.addHandler(function(result){
		janrain_capture_access_denied();
	});
    function handleCaptureLogin(result) {
        console.log ("exchanging code for token");
        var redir = window.top.location.href;
        getTokenForCode(result.authorizationCode, redir);
    }
    janrain.events.onCaptureSessionNotFound.addHandler(function(result) {
        console.log ("Not Found", "Capture session");
        if(getCookie('capture_bb_signedin') == '1'){
        	janrain.capture.ui.createCaptureSession(getCookie('capture_access_token'));
        	location.reload();
        }
    });
    janrain.events.onCaptureSessionFound.addHandler(function(result) {
        console.log ("Found", "Capture session");
        if(getCookie('capture_bb_signedin') != '1'){
        	janrain.capture.ui.endCaptureSession();
        	location.reload();
        }
    });
    
    janrain.events.onCaptureLoginSuccess.addHandler(handleCaptureLogin);
    janrain.events.onCaptureRegistrationSuccess.addHandler(handleCaptureLogin);

    janrain.capture.ui.start();
}