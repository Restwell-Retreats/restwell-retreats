<?php
/**
 * CRM include entry (theme).
 *
 * Loaded by functions.php after the mu-plugin bootstrap. Modules are required
 * from inc/crm/bootstrap.php by the mu-plugin `crm.php` entry point.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'restwell_crm_capability' ) ) {
	require_once __DIR__ . '/crm/bootstrap.php';
}
