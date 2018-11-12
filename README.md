hypeSatis
=========

Allows hosting composer repository with private repositories as part of the Elgg site.

Satis Build
===========

To build Satis composer repository:

```sh
vendor/bin/elgg-cli satis:build
```

You may want to configure a cron job to run this command to pull in new versions of packages at a given interval.

Client Setup
============

First, add username and password of the Elgg account to the client server:

```sh
composer global config http-basic.{{host}} {{username}} {{password}}
```

In ``composer.json`` of the client project add:

```json
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://{{host}}/satis"
        }
    ]
}
```

 * `{{host}}` is the hostname of your Elgg installation
 * `{{username}}` is the username of the Elgg user
 * `{{password}}` is the password of the Elgg user
 


