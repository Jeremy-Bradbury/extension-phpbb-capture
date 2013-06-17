function janrainCaptureWidgetOnLoad() {
	janrain.events.onCaptureAccessDenied.addHandler(function(result){
		janrain_capture_access_denied();
	});
	janrain.events.onCaptureProfileSaveSuccess.addHandler(function(result){
		window.top.location.href = pbb_home+'/redirect.php?update=true';
	});
	janrain.capture.ui.start();
}