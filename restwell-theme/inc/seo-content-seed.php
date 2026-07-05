<?php
/**
 * SEO-oriented default meta and optional blog seeding for Theme Setup.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/seo-content-seed-meta.php';
require_once __DIR__ . '/seo-content-seed-hub-pages.php';
require_once __DIR__ . '/seo-content-seed-blog-priority.php';
require_once __DIR__ . '/seo-content-seed-blog-cluster-a.php';
require_once __DIR__ . '/seo-content-seed-blog-cluster-b.php';
