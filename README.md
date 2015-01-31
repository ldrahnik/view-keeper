ldrahnik/view-keeper
======

[![Build Status](https://travis-ci.org/ldrahnik/view-keeper.svg)](https://travis-ci.org/ldrahnik/view-keeper)
[![Latest stable](https://img.shields.io/packagist/v/ldrahnik/view-keeper.svg)](https://packagist.org/packages/ldrahnik/view-keeper)

Keeper of app views.

Requirements
------------

ldrahnik/view-keeper requires PHP 5.4 or higher.

- [Nette Framework](https://github.com/nette/nette)

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
parameters:
    templatesDir: test

extensions:
	keeper: ViewKeeper\DI\ViewKeeperHelperExtension

keeper:
	controls: %templatesDir%/controls
```

Now you can use templates path through services

```php
	/** @var \ViewKeeper\ViewKeeper @inject */
	private $keeper;

    public function __construct(ViewKeeper\ViewKeeper $keeper)
    {
    	$this->keeper = $keeper;
    }
    
    public function render()
	  {
		  $this->template->setFile($this->keeper->getView($this->name, 'controls'));
		  //equivalent $this->template->setFile($this->keeper->getControlView($this->name);
		  //'Control' will find 'controls' in config
		  
		  $this->template->render();
	  }
```
