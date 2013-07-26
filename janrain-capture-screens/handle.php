<?php
/**
 * Event handler endpoint for server-side event handling
 *
 * Usage handle.php?event=onModalOpen
 */

$event = $_REQUEST['event'];
$arg   = $_REQUEST['arg'];

// allow only alpha-numeric for security
if (!ctype_alnum($event)) {
	header( 'HTTP/1.1 400 Bad Request' );
	exit();
}
if($arg){
	// allow only alpha-numeric for security
	foreach ($arg as $a) {
		if (!ctype_alnum($a)) {
			header( 'HTTP/1.1 400 Bad Request' );
			exit();
		}
	}
	// var_dump($arg);
}


// true switch allows for case by case testing like this
	// case stristr($event, 'onCapture'):
switch (true) {
	case $event == "onAuthWidgetLoad":
		echo $event;
		break;
	case $event == "onAuthWidgetContentPlaced":
		echo $event;
		break;
	case $event == "onCaptureRenderStart":
		echo $event;
		break;
	case $event == "onCaptureRenderComplete":
		echo $event;
		break;
	case $event == "onCaptureScreenShow":
		echo $event;
		break;
	case $event == "onCaptureSessionCreated":
		echo $event;
		break;
	case $event == "onCaptureSessionEnded":
		echo $event;
		break;
	case $event == "onCaptureAccessDenied":
		echo $event;
		break;
	case $event == "onCaptureRegistrationStart":
		echo $event;
		break;
	case $event == "onCaptureLoginStart":
		echo $event;
		break;
	case $event == "onCaptureLoginSuccess":
		echo $event;
		break;
	case $event == "onCaptureProfileSaveSuccess":
		echo $event;
		echo "<br/>here is where we sync $arg[0] data from capture";
		//TODO: sync data from capture
		break;
	case $event == "onCaptureProfileSaveFailed":
		echo $event;
		break;
	case $event == "onCaptureFederateNoLogin":
		echo $event;
		break;
	case $event == "onCaptureFederateLogin":
		echo $event;
		break;
	case $event == "onCaptureFederateRefreshedToken":
		echo $event;
		break;
	case $event == "onCaptureLoginFailed":
		echo $event;
		break;
	case $event == "onCaptureRegistrationSuccess":
		echo $event;
		break;
	case $event == "onCaptureRegistrationFailed":
		echo $event;
		break;
	case $event == "onCaptureEmailVerificationSuccess":
		echo $event;
		break;
	case $event == "onCaptureEmailVerificationFailed":
		echo $event;
		break;
	case $event == "onCaptureForgotPasswordCodeSuccess":
		echo $event;
		break;
	case $event == "onCaptureForgotPasswordCodeFailed":
		echo $event;
		break;
	case $event == "onCaptureSaveSuccess":
		echo $event;
		break;
	case $event == "onCaptureSaveFailed":
		echo $event;
		break;
	case $event == "onCaptureSessionFound":
		echo $event;
		break;
	case $event == "onCaptureSessionNotFound":
		echo $event;
		break;
	case $event == "onCaptureContentChange":
		echo $event;
		break;
	case $event == "onCaptureModalReady":
		echo $event;
		break;
	case $event == "onCaptureValidationSuccess":
		echo $event;
		break;
	case $event == "onCaptureValidationFailed":
		echo $event;
		break;
	case $event == "onCaptureValidationComplete":
		echo $event;
		break;
	case $event == "onCaptureServerValidationFailed":
		echo $event;
		break;
	case $event == "onCaptureFormError":
		echo $event;
		break;
	case $event == "onCaptureProfileCookieSet":
		echo $event;
		break;
	case $event == "onCaptureExpiredToken":
		echo $event;
		break;
	case $event == "onCaptureInvalidToken":
		echo $event;
		break;
	case $event == "onCaptureTransactionTimeout":
		echo $event;
		break;
	case $event == "onCaptureCustomEvent":
		echo $event;
		break;
	case $event == "onCaptureProfileLink":
		echo $event;
		break;
	case $event == "onCaptureEmailSent":
		echo $event;
		break;
	case $event == "onCaptureProfileUnlink":
		echo $event;
		break;
	case $event == "onCapturePhotoUploadSuccess":
		echo $event;
		echo '<br/>here is where we sync data from capture';
		//TODO: sync data from capture
		break;
	case $event == "onCaptureBackplaneReady":
		echo $event;
		break;
	case $event == "onCaptureBackplaneInitFailed":
		echo $event;
		break;
	case $event == "onCaptureAutoSaveUpdate":
		echo $event;
		echo '<br/>here is where we sync data from capture';
		//TODO: sync data from capture
		break;
	case $event == "onCaptureControlSuccesss":
		echo $event;
		break;
	case $event == "onCaptureControlFailed":
		echo $event;
		break;
	case $event == "onCaptureAccountReactivateSuccess":
		echo $event;
		break;
	case $event == "onCaptureAccountReactivateFailed":
		echo $event;
		break;
	case $event == "onCaptureAccountDeactivateSuccess":
		echo $event;
		break;
	case $event == "onCaptureAccountDeactivateFailed":
		echo $event;
		break;
	case $event == "onCaptureLinkAccountError":
		echo $event;
		break;
	case $event == "onCaptureError":
		echo $event;
		break;
	case $event == "onCaptureSubscriptionUpdate":
		echo $event;
		break;
	case $event == "onCaptureRegistrationSuccessNoLogin":
		echo $event;
		break;
	case $event == "onCapturePostLoginScreen":
		echo $event;
		break;
	case $event == "onCaptureEmailVerficationSuccess":
		echo $event;
		break;
	case $event == "onCssLoad":
		echo $event;
		break;
	case $event == "onCustomizationChange":
		echo $event;
		break;
	case $event == "onModalClose":
		echo $event;
		break;
	case $event == "onModalOpen":
		    echo "<script>confirm('$event - render client-side code here if you really have to.');</script>\n$event - or really just put any server-side code here<br>";
		break;
	case $event == "onModalWidgetReady":
		echo $event;
		break;
	case $event == "onReturnExperienceFound":
		echo $event;
		break;
	case $event == "onProviderLoginStart":
		echo $event;
		break;
	case $event == "onProviderLoginCancel":
		echo $event;
		break;
	case $event == "onProviderLoginComplete":
		echo $event;
		break;
	case $event == "onProviderLoginError":
		echo $event;
		break;
	case $event == "onProviderLoginSuccess":
		echo $event;
		break;
	case $event == "onProviderLoginToken":
		echo $event;
		break;
	case $event == "onProviderLogoutStart":
		echo $event;
		break;
	case $event == "onProviderLogoutComplete":
		echo $event;
		break;
	default:
			echo 'handle is not aware of this event.';
		break;
}
