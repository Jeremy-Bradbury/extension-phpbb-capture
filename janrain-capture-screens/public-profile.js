function janrainCaptureWidgetOnLoad() {
    function handleCaptureLogin(result) {

            if (janrain.settings.capture.responseType == 'token') {
                    janrain.capture.ui.modal.close();
            }
    }
    janrain.events.onCaptureSessionFound.addHandler(function(result){
        console.log ("user is logged in");
    });

    janrain.events.onCaptureSessionNotFound.addHandler(function(result){
        console.log ("user is logged out");
    });

    janrain.events.onCaptureLoginSuccess.addHandler(handleCaptureLogin);
    janrain.events.onCaptureRegistrationSuccess.addHandler(handleCaptureLogin);
    
    janrain.capture.ui.start();
}