<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \hypeJunction\Downloads\Download) {
	return;
}

if (!$entity->{'composer:package_name'}) {
    return;
}

$user = elgg_get_logged_in_user_entity();
if (!$user) {
	return;
}

$host = parse_url(elgg_get_site_url(), PHP_URL_HOST);
$output = elgg_echo('downloads:satis:install:instructions', [
	$entity->{'composer:package_name'},
	$host,
	$user->username,
	\hypeJunction\Satis\Satis::makeAccessKey($user),
	elgg_normalize_url('satis'),
]);

echo elgg_view('post/module', [
	'title' => elgg_echo('downloads:satis:install'),
	'body' => $output,
	'collapsed' => false,
	'class' => 'download-deps__module',
]);