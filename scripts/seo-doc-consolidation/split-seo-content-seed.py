#!/usr/bin/env python3
"""Split seo-content-seed.php into cluster files (meta, hub, blog-priority)."""

from pathlib import Path

ROOT = Path(__file__).resolve().parents[2]
INC = ROOT / "restwell-theme" / "inc"
src = (INC / "seo-content-seed.php").read_text(encoding="utf-8")
lines = src.splitlines(keepends=True)

def slice_lines(start: int, end: int) -> str:
    return "".join(lines[start - 1 : end])

header = """<?php
/**
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

"""

# 1-based line numbers from current file
meta_body = slice_lines(15, 291)  # from function restwell_get_seo_meta through apply
hub_body = slice_lines(293, 336) + "\n" + slice_lines(635, 695)
blog_seed_body = slice_lines(338, 633)
blog_html_body = slice_lines(697, 1340)
migrate_body = slice_lines(1342, len(lines))

(INC / "seo-content-seed-meta.php").write_text(
    """<?php
/**
 * SEO meta defaults and apply helpers.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

"""
    + meta_body,
    encoding="utf-8",
)

(INC / "seo-content-seed-hub-pages.php").write_text(
    """<?php
/**
 * Hub page HTML seeds (Who It's For, Whitstable guide).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

"""
    + hub_body,
    encoding="utf-8",
)

(INC / "seo-content-seed-blog-priority.php").write_text(
    """<?php
/**
 * Priority blog post seeding and HTML (posts 1–7 cluster).
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

"""
    + blog_seed_body
    + "\n"
    + blog_html_body
    + migrate_body,
    encoding="utf-8",
)

orchestrator = """<?php
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
"""

(INC / "seo-content-seed.php").write_text(orchestrator, encoding="utf-8")
print("Split seo-content-seed.php into meta, hub-pages, blog-priority")
