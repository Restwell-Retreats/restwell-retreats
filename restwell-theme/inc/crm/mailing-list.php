<?php
/**
 * CRM: marketing opt-in mailing list admin screen.
 *
 * @package Restwell_CRM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render opted-in marketing contacts from site forms.
 */
function restwell_crm_mailing_list_page(): void {
	if ( ! restwell_crm_can_manage() ) {
		wp_die( esc_html__( 'You do not have permission to view this page.', 'restwell-retreats' ) );
	}

	global $wpdb;
	$enq_table = $wpdb->prefix . RESTWELL_CRM_TABLE;
	$faq_table = $wpdb->prefix . RESTWELL_FAQ_TABLE;

	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$rows = $wpdb->get_results(
		"
		SELECT
			email,
			MAX(name) AS name,
			MAX(last_opted_in_at) AS last_opted_in_at,
			GROUP_CONCAT(DISTINCT source ORDER BY source SEPARATOR ', ') AS sources
		FROM (
			SELECT
				email,
				name,
				COALESCE(marketing_optin_at, submitted_at) AS last_opted_in_at,
				'Enquiry form' AS source
			FROM {$enq_table}
			WHERE marketing_optin = 1 AND email <> ''
			UNION ALL
			SELECT
				email,
				name,
				COALESCE(marketing_optin_at, submitted_at) AS last_opted_in_at,
				'FAQ question form' AS source
			FROM {$faq_table}
			WHERE marketing_optin = 1 AND email <> ''
		) all_optins
		GROUP BY email
		ORDER BY last_opted_in_at DESC
		",
		ARRAY_A
	);
	// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Mailing list', 'restwell-retreats' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Contacts who explicitly opted in to marketing emails from enquiry and FAQ forms.', 'restwell-retreats' ); ?>
		</p>
		<?php if ( empty( $rows ) ) : ?>
			<p><?php esc_html_e( 'No opted-in contacts yet.', 'restwell-retreats' ); ?></p>
		<?php else : ?>
			<p><strong><?php echo esc_html( sprintf( __( 'Total subscribers: %d', 'restwell-retreats' ), count( $rows ) ) ); ?></strong></p>
			<table class="widefat striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Name', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Email', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Source', 'restwell-retreats' ); ?></th>
						<th><?php esc_html_e( 'Most recent opt-in', 'restwell-retreats' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<tr>
							<td><?php echo esc_html( (string) ( $row['name'] ?? '' ) ); ?></td>
							<td><a href="mailto:<?php echo esc_attr( (string) ( $row['email'] ?? '' ) ); ?>"><?php echo esc_html( (string) ( $row['email'] ?? '' ) ); ?></a></td>
							<td><?php echo esc_html( (string) ( $row['sources'] ?? '' ) ); ?></td>
							<td><?php echo esc_html( (string) ( $row['last_opted_in_at'] ?? '' ) ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<?php
}

