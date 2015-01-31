<?php
/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
require __DIR__ . '/../../vendor/autoload.php';


if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

Tester\Environment::setup();

$temp = __DIR__ . '/temp/';
if (!file_exists($temp)) {
	mkdir($temp);
} else {
	Tester\Helpers::purge($temp);
}

$configurator = new \Nette\Configurator;
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../../src')
	->register();
$configurator->addConfig(__DIR__ . '/config/config.neon');

return $configurator->createContainer();