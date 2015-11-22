<?php

namespace Craft;

class MinifyService extends BaseApplicationComponent
{

    protected $shouldMinify = true;

    public function init()
    {
	    $envVars = craft()->config->get('environmentVariables');
	    	
        if (isset($envVars['disableTemplateMinifying']) && $envVars['disableTemplateMinifying'])
        {
	        $this->shouldMinify = false;
        }

        if (craft()->config->get('devMode') && isset($envVars['disableDevmodeMinifying']) && $envVars['disableDevmodeMinifying'])
        {
	        $this->shouldMinify = false;
        }
    }

/* --------------------------------------------------------------------------------
	Minify the passed in HTML
-------------------------------------------------------------------------------- */

    public function htmlMin($htmlText="")
    {
	    if ($this->shouldMinify)
	    {
        	$htmlText = \Minify_HTML::minify($htmlText);
        }
        return $htmlText;
    } /* -- htmlMin */

/* --------------------------------------------------------------------------------
	Minify the passed in CSS
-------------------------------------------------------------------------------- */

    public function cssMin($cssText="")
    {
	    if ($this->shouldMinify)
	    {
        	$cssText = \Minify_CSSmin::minify($cssText);
        }
        return $cssText;
    } /* -- cssMin */

/* --------------------------------------------------------------------------------
	Minify the passed in JS
-------------------------------------------------------------------------------- */

    public function jsMin($jsText="")
    {
	    if ($this->shouldMinify)
	    {
	        $jsText = \JSMin\JSMin::minify($jsText);
	    }
        return $jsText;
    } /* -- jsMin */

} /* -- MinifyService */
