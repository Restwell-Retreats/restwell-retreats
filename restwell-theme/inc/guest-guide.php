<?php
/**
 * Guest Guide bootstrap: private arrival guide, OTP, and CRM guest list.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/guest-guide/email.php';
require_once __DIR__ . '/guest-guide/store.php';
require_once __DIR__ . '/guest-guide/admin.php';
require_once __DIR__ . '/guest-guide/otp.php';
require_once __DIR__ . '/guest-guide/meta.php';
