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
	themeDir: %appDir%/templates

extensions:
	keeper: ViewKeeper\DI\ViewKeeperHelperExtension

keeper:
	controls: %themeDir%/<category>/<name>/<view>
	presenters: %themeDir%/<category>/<name>/<view>
	layouts: %themeDir%/@<view>
```

Example of usage, view-keeper is immune to crash in ajax request (no parameters in render method)

```php
	/**
	* @var \ViewKeeper\ViewKeeper 
	* @inject 
	*/
	private $keeper;
	
	public function __construct(ViewKeeper\ViewKeeper $keeper)
    {
		$this->keeper = $keeper;
    }
    
    // components
    public function render()
    {
		$this->template->setFile($this->keeper->getView($this->name, 'controls'));
		$this->template->render();
    }
    	
    // presenters
    public function formatLayoutTemplateFiles()
	{
		return array($this->keeper->getView($this->name, 'layouts', 'layout'));
	}

	public function formatTemplateFiles()
	{
		return array($this->keeper->getView($this->name, 'presenters', $this->action));
	}
```

Or you can use get view via magic

```php
	$this->keeper->getControlView($this->name);
	//will find category in config which is plural of 'Control' & case insensivite => 'controls'
```

Is able to set up path via these patterns

```sh
	<module>		# <Backend>Module
	<name>			# <Backend>Module<:Base>Presenter
					# <Base>Presenter
					# <UserAdd>
	<category> 		# <controls>: ...
	<view> 			# <default>.latte
	
	# suffix is not configurable, always will be in the end over dot
```

View-keeper is easy way to separate template files from logic, you ll love it :)


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/ldrahnik/view-keeper/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

