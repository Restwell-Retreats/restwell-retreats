<?php
/**
 * CRM enquiry delete: ID clean-up, notice wording, and which rows go.
 *
 * @package Restwell_Retreats
 */

/**
 * Records $wpdb writes so the test can check what a delete touches.
 */
class CrmDeleteFakeWpdb {

	/** @var string */
	public $prefix = 'wp_';

	/** @var array<int, array<string, mixed>> */
	public $calls = array();

	/** @var array<int, int|false> Rows "deleted" per enquiry ID; missing IDs report 0. */
	public $enquiry_rows = array();

	public function delete( $table, $where, $format = null ) {
		unset( $format );
		$this->calls[] = array(
			'op'    => 'delete',
			'table' => $table,
			'where' => $where,
		);
		if ( 'wp_rw_enquiries' === $table ) {
			return $this->enquiry_rows[ $where['id'] ] ?? 0;
		}
		return 1;
	}

	public function update( $table, $data, $where, $format = null, $where_format = null ) {
		unset( $format, $where_format );
		$this->calls[] = array(
			'op'    => 'update',
			'table' => $table,
			'data'  => $data,
			'where' => $where,
		);
		return 0;
	}
}

class CrmDeleteEnquiryTest extends PHPUnit\Framework\TestCase {

	/** @var mixed */
	private $saved_wpdb;

	protected function setUp(): void {
		$this->saved_wpdb  = $GLOBALS['wpdb'] ?? null;
		$GLOBALS['wpdb']   = new CrmDeleteFakeWpdb();
	}

	protected function tearDown(): void {
		$GLOBALS['wpdb'] = $this->saved_wpdb;
	}

	public function test_ids_are_positive_unique_integers() {
		$this->assertSame( array( 3, 7 ), restwell_crm_sanitize_enquiry_ids( array( '3', '0', 'abc', '3', 7, '' ) ) );
		$this->assertSame( array( 12 ), restwell_crm_sanitize_enquiry_ids( '12' ) );
		$this->assertSame( array(), restwell_crm_sanitize_enquiry_ids( 0 ) );
		$this->assertSame( array(), restwell_crm_sanitize_enquiry_ids( array() ) );
	}

	public function test_notice_text() {
		$this->assertSame( 'Enquiry deleted.', restwell_crm_deleted_notice_text( 1 ) );
		$this->assertSame( '3 enquiries deleted.', restwell_crm_deleted_notice_text( 3 ) );
		$this->assertStringStartsWith( 'Nothing was deleted.', restwell_crm_deleted_notice_text( 0 ) );
	}

	public function test_notice_text_has_no_em_dashes() {
		foreach ( array( 0, 1, 2 ) as $count ) {
			$this->assertStringNotContainsString( '—', restwell_crm_deleted_notice_text( $count ) );
		}
	}

	public function test_delete_removes_enquiry_and_notes_and_unlinks_guest() {
		$wpdb               = $GLOBALS['wpdb'];
		$wpdb->enquiry_rows = array( 5 => 1 );

		$this->assertSame( 1, restwell_crm_delete_enquiries( array( 5 ) ) );
		$this->assertSame(
			array(
				array(
					'op'    => 'delete',
					'table' => 'wp_rw_enquiries',
					'where' => array( 'id' => 5 ),
				),
				array(
					'op'    => 'delete',
					'table' => 'wp_rw_enquiry_notes',
					'where' => array( 'enquiry_id' => 5 ),
				),
				array(
					'op'    => 'update',
					'table' => 'wp_rw_guests',
					'data'  => array( 'enquiry_id' => null ),
					'where' => array( 'enquiry_id' => 5 ),
				),
			),
			$wpdb->calls
		);
	}

	public function test_delete_counts_only_rows_that_existed() {
		$wpdb               = $GLOBALS['wpdb'];
		$wpdb->enquiry_rows = array(
			5 => 1,
			6 => 1,
		);

		// 9 was already gone: not counted, but any stray notes for it are still cleared.
		$this->assertSame( 2, restwell_crm_delete_enquiries( array( 5, 6, 9 ) ) );
		$notes_deleted = array_filter(
			$wpdb->calls,
			static function ( array $call ): bool {
				return 'delete' === $call['op'] && 'wp_rw_enquiry_notes' === $call['table'];
			}
		);
		$this->assertCount( 3, $notes_deleted );
	}

	public function test_failed_enquiry_delete_keeps_its_notes() {
		$wpdb               = $GLOBALS['wpdb'];
		$wpdb->enquiry_rows = array( 5 => false );

		$this->assertSame( 0, restwell_crm_delete_enquiries( array( 5 ) ) );
		$this->assertCount( 1, $wpdb->calls );
		$this->assertSame( 'wp_rw_enquiries', $wpdb->calls[0]['table'] );
	}
}
