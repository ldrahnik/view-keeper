<?php

namespace ViewKeeper\DI;

use Nette\DI\CompilerExtension;


/**
 * View keeper helper extension.
 *
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 * @package view-keeper\DI
 */
class ViewKeeperHelperExtension extends CompilerExtension
{

	/**
	 * Embedded default configuration.
	 */
	private $defaults = array(
		'controls' => '%appDir%/templates/controls'
	);

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('ViewKeeper'))
			->setClass('ViewKeeper\ViewKeeper',
				array($config)
			);
	}
}