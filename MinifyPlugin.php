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
	    return Craft::t('Minify');
	}

    public function getDescription()
    {
        return 'A simple plugin that allows you to minify blocks of HTML, CSS, and JS inline in Craft CMS templates.';
    }
    
    public function getDocumentationUrl()
    {
        return 'https://github.com/khalwat/minify/blob/master/README.md';
    }
    
    public function getReleaseFeedUrl()
    {
        return 'https://github.com/khalwat/minify/blob/master/releases.json';
    }
    
	public function getVersion()
	{
	    return '1.0.3';
	}

    public function getSchemaVersion()
    {
        return '1.0.0';
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
