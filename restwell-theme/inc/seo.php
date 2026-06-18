<?php
/**
 * SEO: title override, verification tags, canonical/meta, analytics, and JSON-LD.
 *
 * Social OG/Twitter tags live in inc/seo-social-meta.php (priority 5).
 * Modules load in dependency order below.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$restwell_seo_modules = array(
	'meta-helpers.php',
	'description.php',
	'canonical.php',
	'analytics.php',
	'jsonld.php',
);
foreach ( $restwell_seo_modules as $restwell_seo_module ) {
	require_once __DIR__ . '/seo/' . $restwell_seo_module;
}
