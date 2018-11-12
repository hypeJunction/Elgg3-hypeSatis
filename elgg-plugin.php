<?php

return [
	'bootstrap' => \hypeJunction\Satis\Bootstrap::class,

	'routes' => [
		'satis:index' => [
			'path' => '/satis/{path?}',
			'controller' => \hypeJunction\Satis\Controllers\Server::class,
			'middleware' => [
				\hypeJunction\Satis\AuthGatekeeper::class,
			],
			'requirements' => [
				'path' => '.*'
			],
		],
	],
];