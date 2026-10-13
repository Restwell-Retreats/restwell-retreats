<?php
/**
 * Keelie and Nikki's portraits for the optional-care band: the people who
 * answer the phone about care (photos published with consent, 13 Oct 2026).
 * Decorative here; their names are on Our Story.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="care-faces" aria-hidden="true">
	<?php foreach ( array( 'keelie-varney', 'nikki-mackay' ) as $care_face ) : ?>
	<img class="care-faces__photo" src="<?php echo esc_url( restwell_theme_image_url( 'journey/' . $care_face . '.webp' ) ); ?>" alt="" width="1500" height="2000" sizes="5rem" loading="lazy" decoding="async" />
	<?php endforeach; ?>
</div>
