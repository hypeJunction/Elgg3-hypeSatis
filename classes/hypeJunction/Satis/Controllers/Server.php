<?php

namespace hypeJunction\Satis\Controllers;

use Elgg\HttpException;
use Elgg\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Server {

	/**
	 * @param Request $request
	 *
	 * @throws HttpException
	 */
	public function __invoke(Request $request) {

		$path = $request->getParam('path');
		$file = elgg_get_data_path() . 'satis/' . $path;

		try {
			$response = BinaryFileResponse::create($file, 200, [], false, 'inline');
			$response->prepare(_elgg_services()->request);
			$response->send();
			exit;
		} catch (\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $ex) {
			throw new HttpException($ex->getMessage(), ELGG_HTTP_NOT_FOUND);
		} catch (\Exception $ex) {
			throw new HttpException($ex->getMessage(), ELGG_HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}