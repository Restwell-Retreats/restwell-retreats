<?php
/**
 * Accessibility equipment register: the single source for the accessibility
 * page (template-accessibility.php) and the downloadable access statement PDF
 * (inc/access-statement.php). Change kit here, then rebuild the PDF with
 * tools/build-access-statement.mjs.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Every piece of kit and access feature; `group` ties each to a room.
 *
 * @return array<int, array<string, mixed>>
 */
function restwell_accessibility_equipment() {
	return array(
		array(
			'group'         => 'getting-in',
			'name'          => __( 'Parking and getting around', 'restwell-retreats' ),
			'where'         => __( 'Single storey, no internal steps', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/entrance.png',
			'image_alt'     => __( 'Level driveway and front door of the bungalow', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Driveway', 'restwell-retreats' )          => __( 'Private, resin-bound: two off-road spaces, adapted vehicles welcome', 'restwell-retreats' ),
				__( 'Street parking', 'restwell-retreats' )    => __( 'Outside the house if you need extra room. No residents permit on this road; check signs on arrival in case street rules change', 'restwell-retreats' ),
				__( 'Car to front door', 'restwell-retreats' ) => __( 'Step-free path', 'restwell-retreats' ),
				__( 'Floors', 'restwell-retreats' )            => __( 'Level flooring throughout, no carpet lips', 'restwell-retreats' ),
				__( 'Patio', 'restwell-retreats' )             => __( 'Level hard-standing suitable for wheelchairs, with the enclosed garden and BBQ area beyond', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'getting-in',
			'name'          => __( 'Doorways and thresholds', 'restwell-retreats' ),
			'where'         => __( 'Clear openings, measured door-stop to door-stop', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '965 mm',
			'figure_label'  => __( 'Front door clear opening', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Front door', 'restwell-retreats' )            => __( '965 mm clear, level threshold, no step', 'restwell-retreats' ),
				__( 'Porch outer doors', 'restwell-retreats' )     => __( '1720 mm opening, with a full-width ribbed entrance mat', 'restwell-retreats' ),
				__( 'All internal doors', 'restwell-retreats' )    => __( '926 mm clear', 'restwell-retreats' ),
				__( 'Conservatory French doors', 'restwell-retreats' ) => __( '1720 mm opening', 'restwell-retreats' ),
				__( 'Rear French doors', 'restwell-retreats' )     => __( '1720 mm opening, onto the patio', 'restwell-retreats' ),
				__( 'Patio threshold ramp', 'restwell-retreats' )  => __( '20 mm high × 80 mm wide, non-slip', 'restwell-retreats' ),
				__( 'Door furniture', 'restwell-retreats' )        => __( 'White doors with black lever handles, for contrast', 'restwell-retreats' ),
				__( 'Portable ramps', 'restwell-retreats' )        => __( 'Fold-up ramps kept for the front door, yours for the stay and for days out', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'Amico GoLift 400: ceiling track hoist', 'restwell-retreats' ),
			'where'         => __( 'Main bedroom, over the profiling bed', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/BD2-3-LS.jpg',
			'image_alt'     => __( 'Accessible bedroom with ceiling track hoist over the profiling bed', 'restwell-retreats' ),
			'figure'        => '180 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' )   => __( '180 kg / 28 st', 'restwell-retreats' ),
				__( 'Lift and lower', 'restwell-retreats' )      => __( 'Powered', 'restwell-retreats' ),
				__( 'Traverse', 'restwell-retreats' )            => __( 'Manual', 'restwell-retreats' ),
				__( 'Trolley', 'restwell-retreats' )             => __( 'Fixed', 'restwell-retreats' ),
				__( 'Attachment', 'restwell-retreats' )          => __( 'Lifting strap with loop', 'restwell-retreats' ),
				__( 'Coverage', 'restwell-retreats' )            => __( 'Full-room', 'restwell-retreats' ),
				__( 'Thorough examination', 'restwell-retreats' ) => __( 'LOLER, every six months', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'Accora CommunityBed', 'restwell-retreats' ),
			'where'         => __( 'Accessible bedroom, under the ceiling track', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '180 kg',
			'figure_label'  => __( 'Maximum user weight', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' )      => __( '215 kg / 34 st', 'restwell-retreats' ),
				__( 'Maximum user weight', 'restwell-retreats' )    => __( '180 kg / 28 st', 'restwell-retreats' ),
				__( 'Mattress platform', 'restwell-retreats' )      => __( '900 × 2000 mm', 'restwell-retreats' ),
				__( 'Overall frame', 'restwell-retreats' )          => __( '930 × 2250 mm', 'restwell-retreats' ),
				__( 'Platform height', 'restwell-retreats' )        => __( '220–800 mm', 'restwell-retreats' ),
				__( 'Profiling', 'restwell-retreats' )              => __( 'Four-section: backrest with auto-regression, kneebreak, Trendelenburg and anti-Trendelenburg', 'restwell-retreats' ),
				__( 'Mattress', 'restwell-retreats' )               => __( 'Accora Allevia Comfort FirmEdge 90 cm, or Roma Medical MATT 1, both pressure-relieving', 'restwell-retreats' ),
				__( 'Side rails', 'restwell-retreats' )             => __( 'Fabric siderail set, 200 cm', 'restwell-retreats' ),
				__( 'Minimum user height', 'restwell-retreats' )    => __( '1460 mm', 'restwell-retreats' ),
				__( 'Carer access', 'restwell-retreats' )           => __( 'Space for a carer on both sides of the bed', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'Joerns Oxford Midi 180: mobile hoist', 'restwell-retreats' ),
			'where'         => __( 'Kept in the bungalow, usable in any room', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '180 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' )       => __( '180 kg / 28 st', 'restwell-retreats' ),
				__( 'Turning radius', 'restwell-retreats' )          => __( '1235 mm', 'restwell-retreats' ),
				__( 'Legs open, external', 'restwell-retreats' )     => __( '1170 mm', 'restwell-retreats' ),
				__( 'Legs closed, external', 'restwell-retreats' )   => __( '600 mm', 'restwell-retreats' ),
				__( 'Leg height', 'restwell-retreats' )              => __( '100 mm', 'restwell-retreats' ),
				__( 'Ground clearance', 'restwell-retreats' )        => __( '25 mm', 'restwell-retreats' ),
				__( 'Spreader bar height', 'restwell-retreats' )     => __( '525–1660 mm', 'restwell-retreats' ),
				__( 'Emergency descent', 'restwell-retreats' )       => __( 'Manual', 'restwell-retreats' ),
				__( 'Thorough examination', 'restwell-retreats' )    => __( 'LOLER, every six months. Last examined 14 May 2026', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'transfers',
			'name'          => __( 'AAL RS4: transfer and standing aid', 'restwell-retreats' ),
			'compact'       => true,
			'figure'        => '185 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'note'          => __( 'The RS4 is an Able Assist device. It is not an Arjo Sara Stedy, and the two are not interchangeable in a handling plan. Please check your care plan names the right one.', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' ) => __( '185 kg', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Level-access wet room', 'restwell-retreats' ),
			'where'         => __( 'Specified by Care Spaces', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/WR-1-LS.jpg',
			'image_alt'     => __( 'Level-access wet room with grab rails and a shower commode chair', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Floor', 'restwell-retreats' )               => __( 'Level access with no lip, floor-level drain', 'restwell-retreats' ),
				__( 'Toilet support rail', 'restwell-retreats' ) => __( 'NYMAS hinged lift-and-lock, with drop-down leg', 'restwell-retreats' ),
				__( 'Assistance alarm', 'restwell-retreats' )    => __( 'Pull-cord with reset plate and over-door light', 'restwell-retreats' ),
				__( 'Extractor fan', 'restwell-retreats' )       => __( 'Fitted', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'RAZ-AT: tilt-in-space shower commode chair', 'restwell-retreats' ),
			'where'         => __( 'Kept in the wet room', 'restwell-retreats' ),
			'lead'          => true,
			'figure'        => '40°',
			'figure_label'  => __( 'Tilt-in-space', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Tilt-in-space', 'restwell-retreats' )    => __( '40°, with tilt-assist pedal', 'restwell-retreats' ),
				__( 'Seat height', 'restwell-retreats' )      => __( '560 mm', 'restwell-retreats' ),
				__( 'Backrest', 'restwell-retreats' )         => __( 'AdjustaBack, 50 cm, with flip-up armrests', 'restwell-retreats' ),
				__( 'Seat module', 'restwell-retreats' )      => __( 'Moulded, front opening', 'restwell-retreats' ),
				__( 'Footplates', 'restwell-retreats' )       => __( 'Adjustable 410–520 mm, folding plate', 'restwell-retreats' ),
				__( 'Castors', 'restwell-retreats' )          => __( 'Four dual-locking, 5 inch', 'restwell-retreats' ),
				__( 'Headrest', 'restwell-retreats' )         => __( 'Moulded', 'restwell-retreats' ),
				__( 'Commode pan', 'restwell-retreats' )      => __( 'Autoclavable', 'restwell-retreats' ),
				__( 'Hip belt', 'restwell-retreats' )         => __( 'Adjustable', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Mira Select Flex EV: shower valve', 'restwell-retreats' ),
			'figure'        => 'TMV3',
			'figure_label'  => __( 'Thermostatic valve', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Type', 'restwell-retreats' )    => __( 'Thermostatic, TMV3', 'restwell-retreats' ),
				__( 'Fittings', 'restwell-retreats' ) => __( 'Long riser rail, 2 m hose and handset', 'restwell-retreats' ),
				__( 'Accreditation', 'restwell-retreats' ) => __( 'RNIB Tried & Tested', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Drive DeVilbiss: shower stool', 'restwell-retreats' ),
			'compact'       => true,
			'figure'        => '136 kg',
			'figure_label'  => __( 'Safe working load', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Safe working load', 'restwell-retreats' ) => __( '136 kg / 21 st', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Geberit AquaClean Mera Care: wash-dry WC', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Wash', 'restwell-retreats' )       => __( 'WhirlSpray shower, plus lady shower', 'restwell-retreats' ),
				__( 'Dry', 'restwell-retreats' )        => __( 'Warm air dryer', 'restwell-retreats' ),
				__( 'Controls', 'restwell-retreats' )   => __( 'Remote control and touchless wall panel', 'restwell-retreats' ),
				__( 'Odour extraction', 'restwell-retreats' ) => __( 'Fitted, with a soft-closing seat', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'wet-room',
			'name'          => __( 'Ropox Swing: height-adjustable washbasin', 'restwell-retreats' ),
			'figure'        => '750–950 mm',
			'figure_label'  => __( 'Basin height range', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Height range', 'restwell-retreats' )   => __( '750–950 mm, manual adjustment', 'restwell-retreats' ),
				__( 'Mounting', 'restwell-retreats' )       => __( 'Swing basin with dock-in unit', 'restwell-retreats' ),
				__( 'Tap', 'restwell-retreats' )            => __( 'Thermostatic mixer, lever operation, safe-touch body, TMV3 approved', 'restwell-retreats' ),
			),
		),
		array(
			'group'         => 'kitchen',
			'name'          => __( 'NEFF Slide & Hide: oven', 'restwell-retreats' ),
			'where'         => __( 'Open-plan, wheelchair access to worktops', 'restwell-retreats' ),
			'lead'          => true,
			'image'         => 'bungalow/KT-1-LS.jpg',
			'image_alt'     => __( 'Kitchen with seated-height worktops and a NEFF Slide and Hide oven', 'restwell-retreats' ),
			'specs'         => array(
				__( 'Oven', 'restwell-retreats' )   => __( 'NEFF Slide & Hide: the door folds away underneath, so you are not reaching across a hot open door from a seated position', 'restwell-retreats' ),
				__( 'Hob', 'restwell-retreats' )    => __( 'Gas, not induction: no electromagnetic field from the cooktop, which many guests with pacemakers prefer', 'restwell-retreats' ),
				__( 'Storage', 'restwell-retreats' ) => __( 'Microwave and accessible storage at lower levels', 'restwell-retreats' ),
			),
		),
	);
}

/**
 * Rooms (chapters) the equipment is grouped under.
 *
 * @return array<string, array{title: string, lede: string}>
 */
function restwell_accessibility_equipment_groups() {
	return array(
		'getting-in' => array(
			'title' => __( 'Getting in', 'restwell-retreats' ),
			'lede'  => __( 'The driveway is resin-bound, level, and takes two cars including an adapted vehicle. There is no step up into the house from where you park.', 'restwell-retreats' ),
		),
		'transfers'  => array(
			'title' => __( 'Beds and hoists', 'restwell-retreats' ),
			'lede'  => __( 'The accessible bedroom can be set up with one or two profiling beds, depending on what you need.', 'restwell-retreats' ),
		),
		'wet-room'   => array(
			'title' => __( 'Wet room', 'restwell-retreats' ),
			'lede'  => __( 'Level-access throughout, with no lip at the entrance. Specified by Care Spaces.', 'restwell-retreats' ),
		),
		'kitchen'    => array(
			'title' => __( 'Kitchen', 'restwell-retreats' ),
			'lede'  => __( 'Worktops you can reach from a seated position. The living room has a rise-and-recline chair; rear French doors onto the patio give a 1720 mm opening.', 'restwell-retreats' ),
		),
	);
}
