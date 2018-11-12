<?php

namespace hypeJunction\Satis;

use Elgg\EntityNotFoundException;
use Elgg\EntityPermissionsException;
use Elgg\HttpException;
use Elgg\Request;
use hypeJunction\Downloads\Download;

class AuthGatekeeper {

	static $public = [
		'packages.json',
		'include',
	];

	/**
	 * Validate satis package access
	 *
	 * @param Request $request Request
	 *
	 * @throws EntityNotFoundException
	 * @throws EntityPermissionsException
	 * @throws HttpException
	 * @throws HttpException
	 * @throws \LoginException
	 */
	public function __invoke(Request $request) {
		$path = $request->getParam('path');
		list($page, $handle, $package) = explode('/', $path);

		if (in_array($page, self::$public)) {
			return;
		}

		$user = $this->getUser();
		if (!$user) {
			throw new EntityPermissionsException();
		}

		login($user);

		$package = elgg_call(ELGG_IGNORE_ACCESS, function () use ($handle, $package) {
			$packages = elgg_get_entities([
				'types' => 'object',
				'subtypes' => Download::SUBTYPE,
				'metadata_name_value_pairs' => [
					[
						'name' => 'composer:package_name',
						'value' => "$handle/$package",
					]
				],
				'limit' => 1,
			]);

			return $packages ? $packages[0] : null;
		});

		if (!$package instanceof Download || !$package->canDownload()) {
			throw new EntityNotFoundException();
		}

		elgg_entity_gatekeeper($package->guid);

		$package->annotate('satis_download', 1, $package->access_id, $user->guid);
	}

	/**
	 * Resolve user from Authorization header
	 *
	 * @return bool|\ElggUser|false
	 * @throws HttpException
	 */
	protected function getUser() {
		if (elgg_get_config('environment') === 'development' && elgg_is_logged_in()) {
			return elgg_get_logged_in_user_entity();
		}

		if (elgg_is_logged_in()) {
			throw new HttpException("Satis should not be accessed with a logged in user", ELGG_HTTP_BAD_REQUEST);
		}

		$token = _elgg_services()->request->headers->get('Authorization');

		list(, $token) = explode(' ', $token);
		if (!$token) {
			return false;
		}

		list($username, $access_key) = explode(':', base64_decode($token));

		$user = get_user_by_username($username);
		if (!$user) {
			throw new HttpException("API user not found", ELGG_HTTP_FORBIDDEN);
		}

		$hmac = elgg_build_hmac([
			'username' => $username,
			'ts' => (int) $user->satis_access_key_ts,
		]);

		$crypto = new \ElggCrypto();

		if (!$hmac->matchesToken($access_key) || !$crypto->areEqual($user->satis_access_key, $access_key)) {
			throw new HttpException("Invalid API key", ELGG_HTTP_FORBIDDEN);
		}

		return $user;
	}
}