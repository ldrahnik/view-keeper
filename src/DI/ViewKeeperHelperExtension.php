<?php

namespace ViewKeeper\DI;

use Nette\DI\CompilerExtension;

/**
 * Class ViewKeeperHelperExtension
 *
 * @author Lukáš Drahník (http://drahnik-lukas.com/)
 * @package ldrahnik\ViewKeeper\DI
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