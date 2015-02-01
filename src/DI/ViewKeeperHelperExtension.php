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

	public function loadConfiguration()
	{
		$config = $this->getConfig();
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('ViewKeeper'))
			->setClass('ViewKeeper\ViewKeeper',
				array($config)
			);
	}
}