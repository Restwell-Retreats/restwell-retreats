<?php
/**
 * Must-use loader for Restwell CRM.
 *
 * WordPress only auto-loads PHP files in the mu-plugins root; this file
 * bootstraps the plugin directory.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/restwell-crm/restwell-crm.php';
