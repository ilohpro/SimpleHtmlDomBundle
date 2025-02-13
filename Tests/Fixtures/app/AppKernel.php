<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iloh\SimpleHtmlDomBundle\Tests\Fixtures\app;

// get the autoload file
$dir = __DIR__;
$lastDir = null;
while ($dir !== $lastDir) {
	$lastDir = $dir;

	if (is_file($dir.'/autoload.php')) {
		require_once $dir.'/autoload.php';
		break;
	}

	if (is_file($dir.'/autoload.php.dist')) {
		require_once $dir.'/autoload.php.dist';
		break;
	}

	$dir = dirname($dir);
}

use Iloh\SimpleHtmlDomBundle\SimpleHtmlDomBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * App Test Kernel for functional tests.
 */
class AppKernel extends Kernel
{
	public function __construct($environment, $debug)
	{
		parent::__construct($environment, $debug);
	}

	public function registerBundles()
	{
		return array(
			new FrameworkBundle(),
			new SimpleHtmlDomBundle(),
		);
	}

	public function init()
	{
	}

	public function getRootDir()
	{
		return __DIR__;
	}

	public function getCacheDir()
	{
		return sys_get_temp_dir().'/'.Kernel::VERSION.'/simple-html-dom-bundle/cache/'.$this->environment;
	}

	public function getLogDir()
	{
		return sys_get_temp_dir().'/'.Kernel::VERSION.'/simple-html-dom-bundle/logs';
	}

	public function registerContainerConfiguration(LoaderInterface $loader)
	{
		$loader->load(__DIR__.'/config/'.$this->environment.'.yml');
	}

	public function serialize()
	{
		return serialize(array($this->getEnvironment(), $this->isDebug()));
	}

	public function unserialize($str)
	{
		call_user_func_array(array($this, '__construct'), unserialize($str));
	}
}
