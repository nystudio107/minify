<?php

namespace Craft;

class MinifyService extends BaseApplicationComponent
{

/* --------------------------------------------------------------------------------
	Minify the passed in HTML
-------------------------------------------------------------------------------- */

    public function htmlMin($htmlText="")
    {
        $minified_html = \Minify_HTML::minify($htmlText);
        return $minified_html;
    } /* -- htmlMin */

/* --------------------------------------------------------------------------------
	Minify the passed in CSS
-------------------------------------------------------------------------------- */

    public function cssMin($cssText="")
    {
        $minified_css = \Minify_CSSmin::minify($cssText);
        return $minified_css;
    } /* -- cssMin */

/* --------------------------------------------------------------------------------
	Minify the passed in JS
-------------------------------------------------------------------------------- */

    public function jsMin($jsText="")
    {
        $minified_js = \JSMin\JSMin::minify($jsText);
        return $minified_js;
    } /* -- jsMin */

} /* -- MinifyService */
