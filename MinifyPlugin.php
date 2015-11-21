<?php
namespace Craft;

/**
 * Class MinifyPlugin
 */
class MinifyPlugin extends BasePlugin
{
	// Public Methods
	// =========================================================================

    public function init()
    {
        require_once __DIR__ . '/vendor/autoload.php';
    }

	public function getName()
	{
	    return 'Minify';
	}

	public function getVersion()
	{
	    return '1.0.1';
	}

	public function getDeveloper()
	{
	    return 'Megalomaniac';
	}

	public function getDeveloperUrl()
	{
	    return 'http://www.megalomaniac.com';
	}

	public function addTwigExtension()
	{
		Craft::import('plugins.minify.twigextensions.*');

		return new MinifyTwigExtension();
	}
}
