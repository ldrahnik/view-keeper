<?php

namespace ViewKeeper\DI;

use Nette\DI\CompilerExtension;

/**
 * Class ViewKeeperExtension
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\DI
 */
class ViewKeeperExtension extends CompilerExtension
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