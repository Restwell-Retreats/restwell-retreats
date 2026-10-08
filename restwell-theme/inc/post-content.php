<?php
/**
 * Blog post body enhancement (3 Oct 2026 redesign).
 *
 * The seeded guides share one plain skeleton: TL;DR blockquote, H2 sections,
 * one-line H3s, bare bullet lists, a FAQ of H3s and a "Closing" heading. This
 * turns that structure into designed components at render time, so every post
 * (and any future post written the same way) gets them without editing
 * content:
 *
 * - "TL;DR:" blockquote → "In short" summary panel
 * - a section made only of H3 + paragraph pairs → a grid of small cards
 * - "Practical steps" / checklist sections → ticked checklist panel
 * - "Common mistakes" / red flags sections → "avoid" panel
 * - "Frequently asked questions" → the site FAQ accordion (and so FAQ schema)
 * - "Closing" → heading dropped, paragraph styled as a sign-off
 * - every H2 gets an id for the "On this page" rail
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// DOMDocument's API uses camelCase properties (textContent, parentNode).
// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

/**
 * Enhance a post body. Pure DOM work, safe to call on any HTML fragment.
 *
 * @param string $html Post content HTML (after the_content filters).
 * @return string
 */
function restwell_enhance_post_html( $html ) {
	if ( '' === trim( (string) $html ) || ! class_exists( 'DOMDocument' ) ) {
		return $html;
	}
	$doc  = new DOMDocument();
	$prev = libxml_use_internal_errors( true );
	$doc->loadHTML( '<?xml encoding="utf-8"?><div id="rw-post-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	libxml_clear_errors();
	libxml_use_internal_errors( $prev );
	$root = $doc->getElementById( 'rw-post-root' );
	if ( ! $root ) {
		return $html;
	}

	// 1. TL;DR blockquote → summary panel.
	foreach ( iterator_to_array( $root->getElementsByTagName( 'blockquote' ) ) as $quote ) {
		$text = trim( $quote->textContent );
		if ( 0 !== stripos( $text, 'TL;DR' ) ) {
			continue;
		}
		$aside = $doc->createElement( 'aside' );
		$aside->setAttribute( 'class', 'post-summary' );
		$label = $doc->createElement( 'p', __( 'In short', 'restwell-retreats' ) );
		$label->setAttribute( 'class', 'post-summary__label' );
		$aside->appendChild( $label );
		foreach ( iterator_to_array( $quote->childNodes ) as $child ) {
			$aside->appendChild( $child );
		}
		// Drop the "TL;DR:" lead-in (a <strong> or plain text).
		$first = $aside->getElementsByTagName( 'p' )->item( 1 );
		if ( $first ) {
			$strong = $first->getElementsByTagName( 'strong' )->item( 0 );
			if ( $strong && 0 === stripos( trim( $strong->textContent ), 'TL;DR' ) ) {
				$first->removeChild( $strong );
			}
			if ( $first->firstChild && XML_TEXT_NODE === $first->firstChild->nodeType ) {
				$first->firstChild->nodeValue = ltrim( (string) preg_replace( '/^\s*TL;DR:?\s*/i', '', $first->firstChild->nodeValue ) );
			}
		}
		$quote->parentNode->replaceChild( $aside, $quote );
	}

	// 2. Walk H2 sections.
	$used_ids = array();
	$faq_n    = 0;
	foreach ( iterator_to_array( $root->getElementsByTagName( 'h2' ) ) as $h2 ) {
		if ( $h2->parentNode !== $root ) {
			continue;
		}
		$title = trim( $h2->textContent );

		// Siblings up to the next H2.
		$section = array();
		for ( $n = $h2->nextSibling; $n && ! ( XML_ELEMENT_NODE === $n->nodeType && 'h2' === strtolower( $n->nodeName ) ); $n = $n->nextSibling ) {
			if ( XML_ELEMENT_NODE === $n->nodeType ) {
				$section[] = $n;
			}
		}
		$tags = array_map(
			static function ( $el ) {
				return strtolower( $el->nodeName );
			},
			$section
		);

		// Closing: drop the heading, style the paragraph as a sign-off.
		if ( preg_match( '/^(closing|final thoughts|in summary)$/i', $title ) ) {
			$wrap = $doc->createElement( 'div' );
			$wrap->setAttribute( 'class', 'post-closing' );
			$h2->parentNode->insertBefore( $wrap, $h2 );
			foreach ( $section as $el ) {
				$wrap->appendChild( $el );
			}
			$h2->parentNode->removeChild( $h2 );
			continue;
		}

		// Stable id for the rail.
		$base = sanitize_title( $title );
		$id   = '' !== $base ? $base : 'section';
		$i    = 2;
		while ( isset( $used_ids[ $id ] ) ) {
			$id = $base . '-' . $i;
			++$i;
		}
		$used_ids[ $id ] = true;
		if ( ! $h2->hasAttribute( 'id' ) ) {
			$h2->setAttribute( 'id', $id );
		}

		$section_n = count( $section );
		$pairs     = $section_n >= 4 && 0 === $section_n % 2;
		for ( $k = 0; $pairs && $k < $section_n; $k += 2 ) {
			$pairs = 'h3' === $tags[ $k ] && in_array( $tags[ $k + 1 ], array( 'p', 'ul', 'ol' ), true );
		}

		// FAQ → accordion (same markup as template-parts/faq-accordion.php).
		if ( $pairs && preg_match( '/frequently asked|^faqs?$|questions/i', $title ) ) {
			++$faq_n;
			$list = $doc->createElement( 'div' );
			$list->setAttribute( 'class', 'faq-list post-faq' );
			$list->setAttribute( 'data-faq-accordion', '' );
			for ( $k = 0; $k < $section_n; $k += 2 ) {
				$qid  = 'post-faq-' . $faq_n . '-' . ( $k / 2 + 1 );
				$item = $doc->createElement( 'div' );
				$item->setAttribute( 'class', 'faq-item' );
				$head = $doc->createElement( 'h3' );
				$head->setAttribute( 'class', 'faq-item__heading' );
				$btn = $doc->createElement( 'button' );
				$btn->setAttribute( 'type', 'button' );
				$btn->setAttribute( 'class', 'faq-item__trigger' );
				$btn->setAttribute( 'aria-expanded', 'false' );
				$btn->setAttribute( 'id', $qid );
				$btn->setAttribute( 'aria-controls', $qid . '-a' );
				$span = $doc->createElement( 'span' );
				$span->appendChild( $doc->createTextNode( trim( $section[ $k ]->textContent ) ) );
				$icon = $doc->createElement( 'span' );
				$icon->setAttribute( 'class', 'faq-item__icon' );
				$icon->setAttribute( 'aria-hidden', 'true' );
				$btn->appendChild( $span );
				$btn->appendChild( $icon );
				$head->appendChild( $btn );
				$panel = $doc->createElement( 'div' );
				$panel->setAttribute( 'class', 'faq-item__panel' );
				$panel->setAttribute( 'id', $qid . '-a' );
				$panel->setAttribute( 'role', 'region' );
				$panel->setAttribute( 'aria-labelledby', $qid );
				$panel->setAttribute( 'hidden', '' );
				$panel->appendChild( $section[ $k + 1 ] );
				$item->appendChild( $head );
				$item->appendChild( $panel );
				$list->appendChild( $item );
				$section[ $k ]->parentNode && $section[ $k ]->parentNode->removeChild( $section[ $k ] );
			}
			$h2->parentNode->insertBefore( $list, $h2->nextSibling );
			continue;
		}

		// H3 + paragraph pairs → small cards.
		if ( $pairs ) {
			$grid = $doc->createElement( 'div' );
			$grid->setAttribute( 'class', 'post-cards' );
			for ( $k = 0; $k < $section_n; $k += 2 ) {
				$card = $doc->createElement( 'div' );
				$card->setAttribute( 'class', 'post-card' );
				$card->appendChild( $section[ $k ] );
				$card->appendChild( $section[ $k + 1 ] );
				$grid->appendChild( $card );
			}
			$h2->parentNode->insertBefore( $grid, $h2->nextSibling );
			continue;
		}

		// A single list section: checklist or "avoid" panel.
		$kind = '';
		if ( preg_match( '/practical steps|checklist|what to (do|bring|pack|check)|before you|steps/i', $title ) ) {
			$kind = 'do';
		} elseif ( preg_match( '/mistake|avoid|pitfall|red flag|don.t/i', $title ) ) {
			$kind = 'avoid';
		}
		if ( '' !== $kind && array( 'ul' ) === array_values( array_unique( $tags ) ) ) {
			$panel = $doc->createElement( 'div' );
			$panel->setAttribute( 'class', 'post-panel post-panel--' . $kind );
			$h2->parentNode->insertBefore( $panel, $h2 );
			$panel->appendChild( $h2 );
			foreach ( $section as $el ) {
				$el->setAttribute( 'class', trim( $el->getAttribute( 'class' ) . ' post-marks post-marks--' . $kind ) );
				$panel->appendChild( $el );
			}
		}
	}

	// 3. Tables scroll inside a frame on narrow screens.
	foreach ( iterator_to_array( $root->getElementsByTagName( 'table' ) ) as $table ) {
		if ( $table->parentNode && 'div' === strtolower( $table->parentNode->nodeName ) && false !== strpos( (string) $table->parentNode->getAttribute( 'class' ), 'post-table' ) ) {
			continue;
		}
		$frame = $doc->createElement( 'div' );
		$frame->setAttribute( 'class', 'post-table' );
		$table->parentNode->replaceChild( $frame, $table );
		$frame->appendChild( $table );
	}

	$out = '';
	foreach ( $root->childNodes as $child ) {
		$out .= $doc->saveHTML( $child );
	}
	return $out;
}

/**
 * "On this page" entries from enhanced post HTML: every H2 with an id.
 *
 * @param string $html Enhanced HTML.
 * @return array<int, array{id:string, label:string}>
 */
function restwell_post_toc( $html ) {
	$toc = array();
	if ( preg_match_all( '/<h2[^>]*\sid="([^"]+)"[^>]*>(.*?)<\/h2>/is', (string) $html, $m, PREG_SET_ORDER ) ) {
		foreach ( $m as $row ) {
			$toc[] = array(
				'id'    => $row[1],
				'label' => trim( wp_strip_all_tags( $row[2] ) ),
			);
		}
	}
	return $toc;
}
// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
