<?php
/**
 * Printable access statement: the equipment register as a standalone A4
 * document, for occupational therapists, case managers and CHC panels who
 * file a spec sheet rather than read a web page.
 *
 * Served at /accessibility/?access-statement=1 (noindex). It exists to be
 * printed: tools/build-access-statement.mjs loads it in headless Chrome and
 * saves the tagged PDF to assets/downloads/restwell-access-statement.pdf, which
 * the accessibility page offers as a download. Data comes from
 * inc/accessibility-equipment.php, so page and PDF cannot drift apart.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme-relative path of the generated PDF.
 *
 * @return string
 */
function restwell_access_statement_pdf_path() {
	return 'assets/downloads/restwell-access-statement.pdf';
}

/**
 * Public URL of the generated PDF, or '' when it has not been built yet.
 *
 * @return string
 */
function restwell_access_statement_pdf_url() {
	$file = get_template_directory() . '/' . restwell_access_statement_pdf_path();
	if ( ! is_readable( $file ) ) {
		return '';
	}
	return get_template_directory_uri() . '/' . restwell_access_statement_pdf_path() . '?ver=' . (int) filemtime( $file );
}

/**
 * File size of the PDF in a human-readable form ("212 KB"), or ''.
 *
 * @return string
 */
function restwell_access_statement_pdf_size() {
	$file = get_template_directory() . '/' . restwell_access_statement_pdf_path();
	return is_readable( $file ) ? size_format( (int) filesize( $file ), 0 ) : '';
}

/**
 * Bring-your-own slings and mobile hoist notes, shared by the page and the PDF.
 *
 * @return array<string, array{title: string, body: string}>
 */
function restwell_access_statement_notes() {
	return array(
		'slings' => array(
			'title' => __( 'Please bring your own slings', 'restwell-retreats' ),
			'body'  => __( 'Slings are prescribed items of personal care. They are fitted to the individual and to the hoist mechanism, so we cannot safely supply them. Both hoists here take loop-style slings on a two-point spreader bar. Bring the sling the person already uses.', 'restwell-retreats' ),
		),
		'own-hoist' => array(
			'title' => __( 'Bringing your own mobile hoist', 'restwell-retreats' ),
			'body'  => __( 'The bed platform lowers to 220 mm. The Oxford Midi’s legs stand 100 mm high with 25 mm of ground clearance, and its turning radius is 1235 mm. If you are bringing your own hoist, measure its leg height and turning circle against those figures, and tell us what you are bringing so we can set the room up for it.', 'restwell-retreats' ),
		),
		'limits' => array(
			'title' => __( 'What we can’t promise', 'restwell-retreats' ),
			'body'  => __( 'We can’t guarantee every piece of specialist equipment at short notice. Some has to be hired in, and some depends on what’s available that week. What we can promise is a straight answer quickly rather than leaving you hoping.', 'restwell-retreats' ),
		),
	);
}

/**
 * Issue date printed on the statement. Deliberately fixed, not "today": a
 * statement funding panels file as evidence must not re-date itself when the PDF
 * is rebuilt for an unrelated reason. Change it when the figures are re-issued.
 *
 * @return string
 */
function restwell_access_statement_issued() {
	return (string) apply_filters( 'restwell_access_statement_issued', 'October 2026' );
}

/**
 * Date the measurements were last checked on site. Empty until someone sets it
 * (option `restwell_access_statement_measured`, e.g. "6 October 2026"); the
 * statement only prints the line when it has a real date.
 *
 * @return string
 */
function restwell_access_statement_measured() {
	return (string) apply_filters( 'restwell_access_statement_measured', get_option( 'restwell_access_statement_measured', '' ) );
}

/**
 * Serve the print document and stop. Hooked to template_redirect.
 */
function restwell_maybe_render_access_statement() {
	if ( ! isset( $_GET['access-statement'] ) || is_admin() ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	if ( ! is_page_template( 'template-accessibility.php' ) ) {
		return;
	}

	status_header( 200 );
	nocache_headers();
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'X-Robots-Tag: noindex, nofollow' );
	restwell_render_access_statement();
	exit;
}
add_action( 'template_redirect', 'restwell_maybe_render_access_statement', 5 );

/**
 * Print the standalone HTML document.
 */
function restwell_render_access_statement() {
	$groups    = restwell_accessibility_equipment_groups();
	$equipment = restwell_accessibility_equipment();
	$grouped   = array();
	foreach ( $equipment as $item ) {
		$gid = isset( $item['group'] ) ? (string) $item['group'] : '';
		if ( '' === $gid || ! isset( $groups[ $gid ] ) ) {
			$gid = 'getting-in';
		}
		$grouped[ $gid ][] = $item;
	}

	$notes   = restwell_access_statement_notes();
	$phone   = function_exists( 'restwell_get_public_phone_number' ) ? restwell_get_public_phone_number() : '01622 809881';
	$email   = function_exists( 'restwell_get_public_enquiry_email' ) ? restwell_get_public_enquiry_email() : 'hello@restwellretreats.co.uk';
	$issued   = restwell_access_statement_issued();
	$measured = restwell_access_statement_measured();
	$css_url = get_template_directory_uri() . '/assets/css/access-statement.css?ver=' . (int) filemtime( get_template_directory() . '/assets/css/access-statement.css' );
	$logo    = get_template_directory_uri() . '/assets/images/long_logo.png';
	$nbsp    = static function ( $value ) {
		return preg_replace( '/(\d)\s+(?=[a-z°])/u', "$1\u{202F}", (string) $value );
	};
	?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?php esc_html_e( 'Restwell Retreats access statement: equipment and measurements', 'restwell-retreats' ); ?></title>
<meta name="author" content="Restwell Retreats">
<meta name="description" content="<?php esc_attr_e( 'Makes, models, safe working loads and clearances for the adapted bungalow in Whitstable.', 'restwell-retreats' ); ?>">
<?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet -- standalone print document, wp_head is not run here. ?>
<link rel="stylesheet" href="<?php echo esc_url( $css_url ); ?>">
</head>
<body>
<header class="as-masthead">
	<img class="as-masthead__logo" src="<?php echo esc_url( $logo ); ?>" alt="Restwell Retreats" width="180" height="28">
	<p class="as-masthead__issued">
		<?php echo esc_html( sprintf( /* translators: %s: month and year */ __( 'Issued %s', 'restwell-retreats' ), $issued ) ); ?>
		<?php
		if ( '' !== $measured ) :
			?>
		<br><span class="as-masthead__measured"><?php echo esc_html( sprintf( /* translators: %s: date */ __( 'Last measured %s', 'restwell-retreats' ), $measured ) ); ?></span>
		<?php endif; ?>
	</p>
</header>

<main>
	<h1><?php esc_html_e( 'Access statement: equipment and measurements', 'restwell-retreats' ); ?></h1>
	<p class="as-lede"><?php esc_html_e( 'A single-storey adapted bungalow in Whitstable, Kent, for disabled adults, families and carers. This is the spec sheet for occupational therapists, case managers and funding panels: makes, models, safe working loads and clearances, taken from the manufacturers’ own spec sheets and our own tape measure.', 'restwell-retreats' ); ?></p>

	<section class="as-key" aria-labelledby="as-key-h">
		<h2 id="as-key-h"><?php esc_html_e( 'Key figures', 'restwell-retreats' ); ?></h2>
		<ul class="as-key__list">
			<li><strong>965&#8239;mm</strong> <?php esc_html_e( 'Front door, clear opening', 'restwell-retreats' ); ?></li>
			<li><strong>926&#8239;mm</strong> <?php esc_html_e( 'Internal doors, clear width', 'restwell-retreats' ); ?></li>
			<li><strong>180&#8239;kg</strong> <?php esc_html_e( 'Ceiling track hoist, safe working load', 'restwell-retreats' ); ?></li>
		</ul>
	</section>

	<nav class="as-find" aria-label="<?php esc_attr_e( 'In this statement', 'restwell-retreats' ); ?>">
		<span class="as-find__label"><?php esc_html_e( 'In this statement', 'restwell-retreats' ); ?></span>
		<ul class="as-find__list">
			<?php foreach ( $groups as $gid => $meta ) : ?>
				<?php
				if ( empty( $grouped[ $gid ] ) ) {
					continue;
				}
				?>
			<li><a href="#as-room-<?php echo esc_attr( $gid ); ?>"><?php echo esc_html( $meta['title'] ); ?></a></li>
			<?php endforeach; ?>
			<li><a href="#as-limits-h"><?php echo esc_html( $notes['limits']['title'] ); ?></a></li>
		</ul>
	</nav>

	<?php foreach ( $groups as $gid => $meta ) : ?>
		<?php
		if ( empty( $grouped[ $gid ] ) ) {
			continue;
		}
		?>
	<section class="as-room" aria-labelledby="as-room-<?php echo esc_attr( $gid ); ?>">
		<h2 id="as-room-<?php echo esc_attr( $gid ); ?>"><?php echo esc_html( $meta['title'] ); ?></h2>
		<p class="as-room__lede"><?php echo esc_html( $meta['lede'] ); ?></p>

		<?php if ( 'transfers' === $gid ) : ?>
		<aside class="as-note" aria-labelledby="as-slings-h">
			<h3 id="as-slings-h"><?php echo esc_html( $notes['slings']['title'] ); ?></h3>
			<p><?php echo esc_html( $notes['slings']['body'] ); ?></p>
		</aside>
		<?php endif; ?>

		<?php foreach ( $grouped[ $gid ] as $item ) : ?>
			<?php
			$specs  = isset( $item['specs'] ) && is_array( $item['specs'] ) ? $item['specs'] : array();
			$figure = isset( $item['figure'] ) ? (string) $item['figure'] : '';
			$flabel = isset( $item['figure_label'] ) ? (string) $item['figure_label'] : '';
			$where  = isset( $item['where'] ) ? (string) $item['where'] : '';
			$note   = isset( $item['note'] ) ? (string) $item['note'] : '';
			$metric = '' !== $figure && (bool) preg_match( '/\d/', $figure );
			?>
		<article class="<?php echo esc_attr( 'as-item' . ( ! empty( $item['compact'] ) ? ' as-item--compact' : '' ) . ( count( $specs ) <= 5 ? ' as-item--short' : '' ) ); ?>">
			<?php
			$has_table = ! empty( $specs ) && empty( $item['compact'] );
			ob_start();
			?>
			<div class="as-item__head">
				<div>
					<h3><?php echo esc_html( $item['name'] ); ?></h3>
					<?php if ( '' !== $where ) : ?>
					<p class="as-item__where"><?php echo esc_html( $where ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( $metric ) : ?>
				<p class="as-item__figure"><strong><?php echo esc_html( $nbsp( $figure ) ); ?></strong> <?php echo esc_html( $flabel ); ?></p>
				<?php endif; ?>
			</div>
			<?php
			$head_html = ob_get_clean();
			?>
			<?php if ( $has_table ) : ?>
				<?php // The card header lives in the table's thead so it repeats on the next page when a long table breaks. ?>
			<table class="as-specs">
				<caption class="as-visually-hidden"><?php echo esc_html( sprintf( /* translators: %s: equipment name */ __( 'Specifications: %s', 'restwell-retreats' ), $item['name'] ) ); ?></caption>
				<thead>
					<tr><td colspan="2" class="as-specs__headcell"><?php echo $head_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped parts above. ?></td></tr>
				</thead>
				<tbody>
					<?php foreach ( $specs as $label => $value ) : ?>
					<tr>
						<th scope="row"><?php echo esc_html( $label ); ?></th>
						<td><?php echo esc_html( $value ); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php else : ?>
				<?php echo $head_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped parts above. ?>
			<?php endif; ?>
			<?php if ( '' !== $note ) : ?>
			<p class="as-item__note"><?php echo esc_html( $note ); ?></p>
			<?php endif; ?>
		</article>
			<?php if ( 'transfers' === $gid && false !== strpos( (string) $item['name'], 'Oxford Midi' ) ) : ?>
		<aside class="as-note" aria-labelledby="as-own-hoist-h">
			<h3 id="as-own-hoist-h"><?php echo esc_html( $notes['own-hoist']['title'] ); ?></h3>
			<p><?php echo esc_html( $notes['own-hoist']['body'] ); ?></p>
		</aside>
			<?php endif; ?>
		<?php endforeach; ?>
	</section>
	<?php endforeach; ?>

	<section class="as-limits" aria-labelledby="as-limits-h">
		<h2 id="as-limits-h"><?php echo esc_html( $notes['limits']['title'] ); ?></h2>
		<p><?php echo esc_html( $notes['limits']['body'] ); ?></p>
		<p><?php esc_html_e( 'If you need a measurement that isn’t here, ask and we will go and measure it.', 'restwell-retreats' ); ?></p>
	</section>
</main>

<footer class="as-footer">
	<p><strong><?php esc_html_e( 'Restwell Retreats', 'restwell-retreats' ); ?></strong>, <?php esc_html_e( 'Whitstable, Kent. Optional home care comes from our sister company, Continuity of Care Services (CQC rated Good).', 'restwell-retreats' ); ?></p>
	<p>
		<?php esc_html_e( 'Phone', 'restwell-retreats' ); ?> <a href="<?php echo esc_url( 'tel:' . ( function_exists( 'restwell_get_public_phone_tel' ) ? restwell_get_public_phone_tel() : '01622809881' ) ); ?>"><?php echo esc_html( $phone ); ?></a>
		· <?php esc_html_e( 'Email', 'restwell-retreats' ); ?> <a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
		· <a href="https://restwellretreats.co.uk/accessibility/">restwellretreats.co.uk/accessibility</a>
		<span class="as-footer__small"><?php esc_html_e( 'This statement is a snapshot; the live accessibility page is always the current version.', 'restwell-retreats' ); ?></span>
	</p>
</footer>
</body>
</html>
	<?php
}
