<?php

return [
	'downloads:satis:install' => 'Install with composer',
	'downloads:satis:install:instructions' => '
	<p>To install the package, run: <br /><code>composer require %s</code></p>
	<p>If you haven\'t done so yet, configure composer to use your access credentials: <br />
		<code>composer global config http-basic.%s %s %s</code>
	 </p>
	 <p>Then add the repository details to your project\'s <code>composer.json</code>:</p>
	 <pre><code lang="json">
{
	"repositories": [
		{
			"type": "composer",
			"url": %s
		}
	]
}
</code></pre>
	',

	'satis:build:queued' => 'Satis rebuild is running in the background',
	'satis:build' => 'Rebuild Satis',
];