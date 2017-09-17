ldrahnik/view-keeper
======

[![Build Status](https://travis-ci.org/ldrahnik/view-keeper.svg)](https://travis-ci.org/ldrahnik/view-keeper)
[![Latest stable](https://img.shields.io/packagist/v/ldrahnik/view-keeper.svg)](https://packagist.org/packages/ldrahnik/view-keeper)

Keeper of app views.

Benefits
-------

- View-keeper is easy way to separate files from logic (e.g. separate to repositories, it has benefits, rights etc.)
- Change location of files is now easier than ever before

Reference
-------

- [Anee - track manager for sharing tracks and photos](https://github.com/anee/anee)
- [TodoMVC - example nette project](https://github.com/ldrahnik/nette-todomvc)


Requirements
------------

ldrahnik/view-keeper requires PHP 5.4 or higher.

- [Nette Framework](https://github.com/nette/nette)
- [url-matcher](https://github.com/ldrahnik/url-matcher)

Installation
------------

Install keeper to your project using  [Composer](http://getcomposer.org/):

```sh
$ composer require ldrahnik/view-keeper
```

Usage
-----

Register extension in config file

```sh
extensions:
	keeper: ViewKeeper\DI\ViewKeeperExtension

keeper:
	controls: foo/controls/<name>/<view>
	files: foo/<name>/<view>
```

Is able to set up path via these patterns

```sh
	<module>		# <Backend>Module
	<name>			# <Backend>Module<:Base>Presenter
					# <Base>Presenter
					# <UserAdd>
	<view> 			# <default>.latte
```

Suffix is not configurable (still you can change that as param of `getView` method) - always will be in the end over dot

And inject

```php
	/** @var \ViewKeeper\ViewKeeper @inject */
	private $keeper;
```

Summary
-------
View keeper tries to be ultra-light package and simple to use. You will love it :)

For more information about path enrolment please check [url-matcher](https://github.com/ldrahnik/url-matcher)
