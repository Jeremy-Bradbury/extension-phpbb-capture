<?php
/**
 * Endpoint for Janrain to interfac with phpBB
 *
 * modes:
 ** logout   = logs user out of phpBB (and Capture)
 ** refresh  = refreshes the token of current user
 ** update   = updates user meta
 ** TODO: screen	 = load specific screen
 ** auth     = login/register
 *
 */


	// vars needed to load common.php
    define('IN_PHPBB', true);
    $phpbb_root_path = dirname(__FILE__).'/../';
    $phpEx = 'php';
    // expired cookie date
	$exp = new DateTime();
    $exp = $exp->setTimestamp(time()-360000)->format('Y M d h:i:s');
    // includes
    require_once $phpbb_root_path."common.$phpEx";
    require_once $phpbb_root_path."includes/functions_user.$phpEx";
    require_once $phpbb_root_path."includes/auth/janrain_capture/janrain-capture-api.$phpEx";

    /*** logout mode ***/
    if(request_var('logout','') == "true") {
    	//grab the sid from cookies or the logout fails
    	$arr = preg_grep_keys("/phpbb3_[a-z0-9]*_sid/i", $_COOKIE);
    	$sid = array_shift(array_values($arr));
    	$cookie = "document.cookie='capture_bb_signedin=0;expires=$exp;path=/;';";
    	finish_redirect(generate_board_url() . "/ucp.php?mode=logout&sid=$sid", $cookie);
    }

    /*** token refresh mode ***/
    if(request_var('refresh','') == "true") {
    	// refresh token
    	$api = new JanrainCaptureAPI();
    	$api->refresh_access_token();
    	finish_redirect();
    }

    /*** update user data mode ***/
    if (request_var('update', '') == 'true' && isset($_COOKIE['capture_access_token'])) {
    	$api = new JanrainCaptureAPI();
    	$user_entity = $api->call('entity', false, $_COOKIE['capture_access_token']);
    	$user_entity = $user_entity['result'];
    	// mapping
    	// $loc = $user_entity['primaryAddress']['city'] . ', ' . $user_entity['primaryAddress']['stateAbbreviation'];
      	$data['gender']   = $user_entity['gender'];
      	$data['location'] = $user_entity['currentLocation']; //(trim($loc) == ",") ? null : $loc;
      	// update user data
      	//var_dump($user_entity['uuid']);die;
    	if ( update_user_data($user_entity['uuid'], $data) != true ) {
    		header('HTTP/1.1 400 Bad Request');
    		exit();
    	}
    	// passing nothing/null reloads the previous page
    	finish_redirect();
    }

    /*** auth mode ***/
    // grab and validate the code and other variables
	$code = request_var('code','');
    if (!ctype_alnum($code)) {
    	janrain_capture_error('no valid code recieved');
    	finish_redirect(generate_board_url());
    }
    $origin = $redirect_args['origin'] = request_var('origin', generate_board_url());
    $redirect_uri = preg_replace('/\?.*/', '', current_page_url());
    // get Capture user entity
    $api = new JanrainCaptureApi();
    $api->new_access_token( $code,  $redirect_uri);
    $user_entity = $api->load_user_entity();
    // valid user returned?
    if ( is_array( $user_entity ) && $user_entity['stat'] == 'ok' ) {
      $user_entity = $user_entity['result'];
      
      /* @@@ BEGIN map custom profile fields @@@ */
      // $data[<custom profile field>] = $user_entity[<capture profile field>]
      $data['gender']   = $user_entity['gender'];
      $data['location'] = $user_entity['currentLocation'];
      //$loc = $user_entity['primaryAddress']['city'] . ', ' . $user_entity['primaryAddress']['stateAbbreviation'];
      //$loc = (trim($loc) == ",") ? null : $loc;
      /* @@@ END map custom profile fields @@@ */

      // lookup local user based on returned uuid
      $bb_user = janrain_capture_user_lookup($user_entity['uuid']);
      // existing user?
      if ($bb_user !== false) {
      	// login user
	    $auth->login($bb_user['capture_uuid'], false);
	    // update custom user data
		update_user_data($user->data['user_id'],$data);
	  } else {
	  	// create new user
		$user->session_begin();
		$auth->acl($user->data);
		$user_row = array(
		// required fields
			'username' => $user_entity['displayName'],
			'user_email' => $user_entity['email'],
			'group_id' => 2, #Registered users group
			'user_type' => '0',
		    'capture_uuid' => $user_entity['uuid'],
		// messaging fields
		    'user_jabber' => '',
			'user_yim' => '',
			'user_aim' => '',
			'user_msnm' => '',
			'user_birthday' => (isset($user_entity['birthday'])) ? $user_entity['birthday'] : '',
		// misc fields
			'user_timezone' => '1.00',
			'user_dst' => 0,
			'user_lang' => 'en',
			'user_actkey' => '',
			'user_dateformat' => 'd M Y H:i',
			'user_style' => 1,
			'user_regdate' => time(),
		);
		// check if username is already there, same for email, otherwhise a nasty error will occur
		$user_exist = validate_username($user_row['username']);
		$email_exist = validate_email($user_entity['email']);
		//create user if it does not exist
		if ($user_exist == false && $email_exist == false) {
			//register user
			$user_id = user_add($user_row);
			//login user
			$auth->login($user_entity['uuid'], false);
			//update custom user data
		    update_user_data($user_id,$data);
		} else {
			janrain_capture_error($user_exist); // comment to hide debug data
			janrain_capture_error($email_exist); // comment to hide debug data
		}
	  }
    } else {
    	janrain_capture_error($user_entity); // comment to hide debug data
    }
    // user internet
    if ($user->data['user_id'] != ANONYMOUS){
  	    $cookie = "document.cookie='capture_bb_signedin=1;path=/;';";
  	} else {
  		$cookie = "document.cookie='capture_bb_signedin=0;expires=$exp;path=/;';";
  	}
  	$r = ($origin) ? $origin : generate_board_url();
  	finish_redirect($r, $cookie);
?>