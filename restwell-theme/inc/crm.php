<?php
/**
 * CRM include entry (theme).
 *
 * Loaded from functions.php. Modules live in inc/crm/.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'restwell_crm_capability' ) ) {
	require_once __DIR__ . '/crm/bootstrap.php';
}
