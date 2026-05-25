<?php
/**
 * REST API hardening: block anonymous enumeration of users via /wp/v2/users.
 *
 * @package Restwell_Retreats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Deny unauthenticated requests to the users collection and per-ID user objects.
 *
 * Logged-in users (any role) keep access so the block editor and `who=authors` queries continue to work.
 * Anonymous clients only see 401, closing the common username harvest vector without redirect hacks.
 *
 * @param mixed            $result  Response to replace the requested version with.
 * @param WP_REST_Server   $server  Server instance.
 * @param WP_REST_Request  $request Request used to generate the response.
 * @return mixed
 */
function restwell_rest_pre_dispatch_block_users_enumeration( $result, $server, $request ) {
	unset( $server );
	if ( ! empty( $result ) ) {
		return $result;
	}
	if ( ! $request instanceof WP_REST_Request ) {
		return $result;
	}

	if ( is_user_logged_in() ) {
		return $result;
	}

	$route = $request->get_route();
	if ( ! is_string( $route ) || $route === '' ) {
		return $result;
	}

	if ( strpos( $route, '/wp/v2/users' ) !== 0 ) {
		return $result;
	}

	// Let core handle anonymous "current user" (typically 401).
	if ( '/wp/v2/users/me' === $route ) {
		return $result;
	}

	return new WP_Error(
		'rest_user_cannot_view',
		__( 'Sorry, you are not allowed to list users.', 'restwell-retreats' ),
		array( 'status' => 401 )
	);
}
add_filter( 'rest_pre_dispatch', 'restwell_rest_pre_dispatch_block_users_enumeration', 10, 3 );
