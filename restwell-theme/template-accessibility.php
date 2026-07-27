<?php
/**
 * Template Name: Accessibility
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pid = get_the_ID();

$acc_hero_image_id = (int) get_post_meta( $pid, 'acc_hero_image_id', true );
$acc_label          = get_post_meta( $pid, 'acc_label', true ) ?: 'Accessibility';
$acc_heading        = get_post_meta( $pid, 'acc_heading', true ) ?: 'Wheelchair accessible holiday cottage';
$acc_intro          = get_post_meta( $pid, 'acc_intro', true ) ?: 'This wheelchair accessible holiday cottage access statement covers the ceiling hoist, level-access wet room, door widths of 965mm at the front and 926mm inside, and parking, so you can judge fit before you book.';

// Room by room: verified facts from restwell_get_property_facts(); headings remain editable in WP.
$acc_room_label       = get_post_meta( $pid, 'acc_room_label', true ) ?: 'The property';
$acc_room_heading     = get_post_meta( $pid, 'acc_room_heading', true ) ?: 'Room by room';
$acc_room_intro       = get_post_meta( $pid, 'acc_room_intro', true ) ?: 'Here is what we have verified about each part of the property. Anything not listed has not been confirmed; ask us and we will find out.';

$rooms = function_exists( 'restwell_get_accessibility_rooms_from_facts' )
	? restwell_get_accessibility_rooms_from_facts( $pid )
	: array();

$acc_dest_label             = get_post_meta( $pid, 'acc_dest_label', true ) ?: 'The destination';
$acc_dest_heading           = get_post_meta( $pid, 'acc_dest_heading', true ) ?: 'Whitstable: what to expect';
$acc_dest_intro             = get_post_meta( $pid, 'acc_dest_intro', true ) ?: 'An honest picture of the area: what is accessible, where there are challenges, and what matters most for your visit.';
$acc_dest_good_heading      = get_post_meta( $pid, 'acc_dest_good_heading', true ) ?: 'The good';
$acc_dest_good_body         = get_post_meta( $pid, 'acc_dest_good_body', true ) ?: 'The Tankerton promenade is a long, flat, surfaced path along the seafront, one of the most wheelchair-friendly coastal routes in Kent. Free parking at Marine Parade. Accessible toilets at the harbour end. The streets around the property are flat and paved with dropped kerbs.';
$acc_dest_challenge_heading = get_post_meta( $pid, 'acc_dest_challenge_heading', true ) ?: 'The challenge';
$acc_dest_challenge_body    = get_post_meta( $pid, 'acc_dest_challenge_body', true ) ?: 'Harbour Street and the old town have narrow pavements that get crowded at weekends and in summer. Some shops and cafes have stepped entrances with no ramp. The harbour itself has some uneven surfaces near the fish market. Weekday mornings are the easiest time to visit.';
$acc_dest_reality_heading   = get_post_meta( $pid, 'acc_dest_reality_heading', true ) ?: 'The reality';
$acc_dest_reality_body      = get_post_meta( $pid, 'acc_dest_reality_body', true ) ?: "Whitstable's beach is shingle. We want to be honest: shingle beaches are generally not wheelchair-friendly. The promenade above the beach provides excellent views and is accessible for most wheelchair users. There are also accessible cafes and restaurants along the seafront at street level.";

$access_statement_url = restwell_get_access_statement_url();
$access_statement_url = $access_statement_url !== '' ? esc_url( $access_statement_url ) : '';
$acc_tldr_markup      = function_exists( 'restwell_get_tldr_markup' ) ? restwell_get_tldr_markup( $pid, '' ) : '';

$acc_gallery_label   = get_post_meta( $pid, 'acc_gallery_label', true ) ?: __( 'Accessibility features', 'restwell-retreats' );
$acc_gallery_heading = get_post_meta( $pid, 'acc_gallery_heading', true ) ?: __( 'Equipment and access in pictures', 'restwell-retreats' );
$acc_gallery_intro   = get_post_meta( $pid, 'acc_gallery_intro', true ) ?: '';
$acc_gallery_ids     = restwell_get_accessibility_gallery_ids( $pid );
?>
<main class="flex-1 restwell-wif-page" id="main-content">
<?php get_template_part( 'template-parts/breadcrumb' ); ?>

	<?php
	set_query_var(
		'args',
		array(
			'heading_id'  => 'page-hero-heading',
			'label'       => $acc_label,
			'heading'     => $acc_heading,
			'intro'       => $acc_intro,
			'media_id'    => $acc_hero_image_id,
			'append_after_h1_html' => $acc_tldr_markup,
		)
	);
	get_template_part( 'template-parts/interior-hero' );
	?>

	<section class="rw-section-y bg-[var(--bg-subtle)]" aria-labelledby="acc-room-heading">
		<div class="container max-w-5xl">

			<div class="rw-section-head max-w-prose">
				<?php if ( $acc_room_label !== '' ) : ?>
					<p class="section-label"><?php echo esc_html( $acc_room_label ); ?></p>
				<?php endif; ?>
				<h2 id="acc-room-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $acc_room_heading ); ?></h2>
				<?php if ( $acc_room_intro !== '' ) : ?>
					<p class="text-[var(--muted-grey)] leading-relaxed m-0"><?php echo esc_html( $acc_room_intro ); ?></p>
				<?php endif; ?>
			</div>

			<div class="grid sm:grid-cols-2 rw-gap-grid">
				<?php
				foreach ( $rooms as $room ) :
					$lines = array_values(
						array_filter(
							array_map(
								'trim',
								is_array( $room['facts'] ?? null ) ? $room['facts'] : array()
							),
							static function ( $line ) {
								return $line !== '';
							}
						)
					);
					if ( empty( $lines ) ) {
						continue;
					}
					?>
					<article class="flex flex-col rw-card-elevated rw-card-elevated--interactive">
						<header class="flex items-center gap-4 px-6 pt-6 pb-5 border-b border-gray-100/80">
							<div class="wif-icon-circle wif-icon-circle--feature h-10 w-10 shrink-0" aria-hidden="true">
								<i class="ph-bold ph-check text-sm"></i>
							</div>
							<h3 class="text-lg font-serif text-[var(--deep-teal)] m-0 leading-snug"><?php echo esc_html( $room['heading'] ); ?></h3>
						</header>
						<div class="flex-1 px-6 py-5">
							<ul class="m-0 list-none p-0 space-y-3 text-sm leading-relaxed text-[var(--muted-grey)]">
								<?php foreach ( $lines as $line ) : ?>
									<li class="flex items-start gap-3 text-left">
										<span class="wif-icon-circle wif-icon-circle--muted h-5 w-5 shrink-0 mt-0.5" aria-hidden="true">
											<i class="ph-bold ph-check text-[10px]"></i>
										</span>
										<span class="min-w-0"><?php echo esc_html( $line ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="mt-10 md:mt-12 grid md:grid-cols-2 rw-gap-grid">
				<article class="flex h-full min-h-0 flex-col rw-card-elevated overflow-hidden">
					<div class="flex items-start gap-4 px-6 pt-6 pb-5">
						<div class="wif-icon-circle wif-icon-circle--feature h-10 w-10 shrink-0" aria-hidden="true">
							<i class="ph-bold ph-chat-circle-text text-sm"></i>
						</div>
						<div>
							<h3 class="text-[1.05rem] font-serif text-[var(--deep-teal)] m-0 mb-1.5 leading-snug"><?php esc_html_e( 'Have a specific requirement?', 'restwell-retreats' ); ?></h3>
							<p class="text-[var(--muted-grey)] leading-relaxed text-sm m-0"><?php esc_html_e( 'We are happy to discuss access needs, measurements, or equipment availability. Get in touch and we will answer honestly.', 'restwell-retreats' ); ?></p>
						</div>
					</div>
					<footer class="mt-auto border-t border-gray-100 px-6 py-5">
						<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary btn-sm w-full text-center whitespace-normal leading-snug">
							<?php esc_html_e( 'Ask us directly', 'restwell-retreats' ); ?>
							<i class="ph-bold ph-arrow-right text-xs" aria-hidden="true"></i>
						</a>
					</footer>
				</article>
				<article class="flex h-full min-h-0 flex-col rw-card-elevated overflow-hidden">
					<div class="flex items-start gap-4 px-6 pt-6 pb-5">
						<div class="wif-icon-circle wif-icon-circle--feature h-10 w-10 shrink-0" aria-hidden="true">
							<i class="ph-bold ph-ruler text-sm"></i>
						</div>
						<div>
							<h3 class="text-[1.05rem] font-serif text-[var(--deep-teal)] m-0 mb-1.5 leading-snug"><?php esc_html_e( 'Need precise measurements?', 'restwell-retreats' ); ?></h3>
							<p class="text-[var(--muted-grey)] leading-relaxed text-sm m-0"><?php esc_html_e( 'Door widths, turning circles, bed heights, grab rail positions: we can provide exact figures for any room in the property.', 'restwell-retreats' ); ?></p>
						</div>
					</div>
					<footer class="mt-auto border-t border-gray-100 px-6 py-5">
						<a href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>" class="btn btn-primary btn-sm w-full text-center whitespace-normal leading-snug">
							<?php esc_html_e( 'Request measurements', 'restwell-retreats' ); ?>
							<i class="ph-bold ph-arrow-right text-xs" aria-hidden="true"></i>
						</a>
					</footer>
				</article>
			</div>

		</div>
	</section>

	<?php if ( ! empty( $acc_gallery_ids ) ) : ?>
	<section class="rw-section-y bg-white" aria-labelledby="acc-gallery-heading">
		<div class="container max-w-5xl">
			<div class="rw-section-head max-w-prose">
				<?php if ( $acc_gallery_label !== '' ) : ?>
					<p class="section-label"><?php echo esc_html( $acc_gallery_label ); ?></p>
				<?php endif; ?>
				<h2 id="acc-gallery-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $acc_gallery_heading ); ?></h2>
				<?php if ( $acc_gallery_intro !== '' ) : ?>
					<p class="text-[var(--muted-grey)] leading-relaxed m-0"><?php echo esc_html( $acc_gallery_intro ); ?></p>
				<?php endif; ?>
			</div>
			<?php
			restwell_render_gallery(
				$acc_gallery_ids,
				array(
					'layout'     => 'grid',
					'aria_label' => __( 'Accessibility feature photos: shower, hoist, entrances, profiling bed, and door clearances', 'restwell-retreats' ),
				)
			);
			?>
		</div>
	</section>
	<?php endif; ?>

	<section class="rw-section-y bg-[var(--soft-sand)]" aria-labelledby="acc-dest-heading">
		<div class="container max-w-5xl">

			<div class="rw-section-head max-w-prose">
				<?php if ( $acc_dest_label !== '' ) : ?>
					<p class="section-label"><?php echo esc_html( $acc_dest_label ); ?></p>
				<?php endif; ?>
				<h2 id="acc-dest-heading" class="text-3xl md:text-4xl font-serif text-[var(--deep-teal)] m-0 leading-tight"><?php echo esc_html( $acc_dest_heading ); ?></h2>
				<p class="text-[var(--muted-grey)] leading-relaxed m-0"><?php echo esc_html( $acc_dest_intro ); ?></p>
			</div>

			<div class="grid md:grid-cols-3 rw-gap-grid">

				<article class="flex flex-col rw-card-elevated rw-card-elevated--interactive">
					<div class="flex items-start gap-4 px-6 pt-6 pb-4">
						<div class="wif-icon-circle wif-icon-circle--feature h-10 w-10 shrink-0" aria-hidden="true">
							<i class="ph-bold ph-check-circle text-base"></i>
						</div>
						<h3 class="text-[1.05rem] font-serif text-[var(--deep-teal)] m-0 pt-1.5 leading-snug"><?php echo esc_html( $acc_dest_good_heading ); ?></h3>
					</div>
					<div class="flex-1 px-6 pb-6 border-t border-gray-100/60">
						<p class="text-[var(--muted-grey)] text-sm leading-relaxed m-0 pt-4"><?php echo esc_html( $acc_dest_good_body ); ?></p>
					</div>
				</article>

				<article class="flex flex-col rw-card-elevated rw-card-elevated--interactive">
					<div class="flex items-start gap-4 px-6 pt-6 pb-4">
						<div class="wif-icon-circle wif-icon-circle--muted h-10 w-10 shrink-0" aria-hidden="true">
							<i class="ph-bold ph-warning text-base"></i>
						</div>
						<h3 class="text-[1.05rem] font-serif text-[var(--deep-teal)] m-0 pt-1.5 leading-snug"><?php echo esc_html( $acc_dest_challenge_heading ); ?></h3>
					</div>
					<div class="flex-1 px-6 pb-6 border-t border-gray-100/60">
						<p class="text-[var(--muted-grey)] text-sm leading-relaxed m-0 pt-4"><?php echo esc_html( $acc_dest_challenge_body ); ?></p>
					</div>
				</article>

				<article class="flex flex-col rw-card-elevated rw-card-elevated--interactive">
					<div class="flex items-start gap-4 px-6 pt-6 pb-4">
						<div class="wif-icon-circle wif-icon-circle--muted h-10 w-10 shrink-0" aria-hidden="true">
							<i class="ph-bold ph-info text-base"></i>
						</div>
						<h3 class="text-[1.05rem] font-serif text-[var(--deep-teal)] m-0 pt-1.5 leading-snug"><?php echo esc_html( $acc_dest_reality_heading ); ?></h3>
					</div>
					<div class="flex-1 px-6 pb-6 border-t border-gray-100/60">
						<p class="text-[var(--muted-grey)] text-sm leading-relaxed m-0 pt-4"><?php echo esc_html( $acc_dest_reality_body ); ?></p>
					</div>
				</article>

			</div>
		</div>
	</section>

	<?php if ( $access_statement_url !== '' ) : ?>
	<section class="rw-section-y bg-white" aria-labelledby="acc-statement-heading">
		<div class="container max-w-5xl">
			<div class="rounded-2xl border border-[var(--deep-teal)]/15 bg-[var(--bg-subtle)] p-8 md:p-10 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] max-w-2xl mx-auto">
				<div class="wif-icon-circle wif-icon-circle--feature h-12 w-12 mx-auto mb-5" aria-hidden="true">
					<i class="ph-bold ph-file-pdf text-xl"></i>
				</div>
				<h2 id="acc-statement-heading" class="text-2xl md:text-3xl font-serif text-[var(--deep-teal)] mb-3 m-0"><?php esc_html_e( 'Download our access statement', 'restwell-retreats' ); ?></h2>
				<p class="text-[var(--muted-grey)] leading-relaxed mb-7 max-w-prose mx-auto m-0"><?php esc_html_e( 'A PDF summary of access routes, door widths, equipment, and the local area, useful for OTs, commissioners, and planning your stay.', 'restwell-retreats' ); ?></p>
				<a href="<?php echo esc_url( $access_statement_url ); ?>" class="inline-flex items-center justify-center gap-2 bg-[var(--deep-teal)] text-white font-semibold px-8 py-3.5 rounded-2xl text-base hover:opacity-90 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--deep-teal)] no-underline" rel="noopener noreferrer" target="_blank">
					<i class="ph-bold ph-file-pdf" aria-hidden="true"></i>
					<?php esc_html_e( 'Open access statement (PDF)', 'restwell-retreats' ); ?>
					<span class="sr-only"><?php esc_html_e( '(opens in new tab)', 'restwell-retreats' ); ?></span>
				</a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="rw-section-y bg-[var(--bg-subtle)]" aria-labelledby="acc-related-heading">
		<div class="container max-w-5xl">
			<div class="rw-section-head max-w-prose">
				<p class="section-label"><?php esc_html_e( 'Related reading', 'restwell-retreats' ); ?></p>
				<h2 id="acc-related-heading" class="text-3xl font-serif text-[var(--deep-teal)] m-0"><?php esc_html_e( 'Before you enquire', 'restwell-retreats' ); ?></h2>
				<p class="text-[var(--muted-grey)] m-0 leading-relaxed max-w-prose"><?php esc_html_e( 'Everything you need to judge whether the property is right for your situation, before committing to anything.', 'restwell-retreats' ); ?></p>
			</div>
			<div class="flex flex-wrap gap-3">
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/the-property/' ) ); ?>"><?php esc_html_e( 'The property', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/who-its-for/' ) ); ?>"><?php esc_html_e( 'Who it is for', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'Frequently asked questions', 'restwell-retreats' ); ?></a>
				<a class="btn btn-outline btn-sm" href="<?php echo esc_url( home_url( '/enquire/' ) ); ?>"><?php esc_html_e( 'Send an enquiry', 'restwell-retreats' ); ?></a>
			</div>
		</div>
	</section>

</main>
<?php get_footer(); ?>
