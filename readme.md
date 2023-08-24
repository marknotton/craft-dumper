
Add [VarDumper](https://symfony.com/doc/current/components/var_dumper.html) methods to Twig

## Installation

#### Composer.json

**This is a private module**, so there are some security measures we need to handle before we can get it installed. You will need [valid SSH permissions](https://support.atlassian.com/bitbucket-cloud/docs/add-access-keys/) set up on the Yello Studio BitBucket account; otherwise this plugin won't install and an error will be thrown. Then you'll need to specify a configuration in the [repositories](https://getcomposer.org/doc/05-repositories.md#composer) settings.

```
"repositories": [{
	"type": "vcs",
	"url": "https://yelloserver:GNQpz2dVD97x8bChY4GZ@bitbucket.org/yellostudio/dumper.git"
}]
```

#### Install with Composer

```
composer require yellostudio/dumper
```

#### Examples

##### Dump

Renders the content in a standard dump

```{{ entry|dump }}```

![enter image description here](https://i.imgur.com/JOzGBX2.png)

#### Inspect

List out all available methods, properties, data, and other properties where available

```{{ entry|inspect }}```

![enter image description here](https://i.imgur.com/b25oI4A.png)

