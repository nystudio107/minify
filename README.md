# Minify plugin for Craft CMS

A simple plugin that allows you to minify blocks of HTML, CSS, and JS inline in Craft CMS templates

Related: [Minify for Craft 3.x](https://github.com/nystudio107/craft3-minify)

**Installation**

1. Download & unzip the file and place the `minify` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/khalwat/minify.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3.  -OR- install with Composer via `composer require nystudio107/minify`
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `minify` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

## Configuring Minify

There is nothing to configure

## Using the Minify plugin in your templates

Minify adds several block tags for minifying HTML, CSS, and JS inline in your templates.  Minify does **not** minify external CSS or JS files.  Use `grunt` or `gulp` task runners to set up a workflow that minimizes these as part of your build process.

You can nest any number of the various `{% minify %}` tags as you wish.

## Why minify inline HTML/CSS/JS code?

Twig provides the `{% spaceless %}` tag, but it is not intended for use as a way to properly minify HTML/CSS/JS code.

You already properly `gzip` output via `mod_deflate` with Apache or by enabling compression with `Nginx` for optimal delivery on production.  You already use a task runner like `grunt` or `gulp` or CodeKit to minimize static resources like CSS/JS files.  What's the point of minifying HTML/CSS/JS inline?

Firstly, you want to keep HTML/CSS/JS comments and a nice hierarchical structure to your code, with plenty of readable whitespace for development, but want all of this stripped out of the HTML/CSS/JS that is served to your frontend.

Secondly, not all CSS/JS can or should be in static asset files.  Sometimes you need inline Javascript for efficiency reasons, or if you're using `JSON-LD` for Google Structured Data/SEO purposes inline in your HTML files.  You may also want to be able to use the Craft templating engine in your CSS/JS itself.

Finally, if you minify any code you wrap in `{% cache %}` tags, that means it will be stored minified in the database, reducing db size and (marginally) transactional overhead.

### Minifying Everything

You can wrap any arbitrary HTML/Twig code in the following block tags to minify it:

	{% minify %}
		(HTML/Twig code here)
    {% endminify %}

...and the resulting HTML output will be stripped of comments, empty space, etc.

Using the `{% minify %}` on its own with no parameters (see below) will minify HTML, as well as any inline CSS (in `<style>` tag pairs) and any inline Javascript (in `<script>` tag pairs).


### Minifying HTML

You can wrap any arbitrary HTML/Twig code in the following block tags to minify it:

	{% minify html %}
		(HTML/Twig code here)
    {% endminify %}

...and the resulting HTML output will be stripped of comments, empty space, etc.

It will ignore `<script>` and `<style>` tag pairs in the minification.  You should specifically wrap your inline CSS/JS in `{% minify css %}` and `{% minify js}` tag blocks if you want those minimized as well; see below.

### Minifying CSS

You can wrap any arbitrary `<style>` CSS code in the following block tags to minify it:

	{% minify css %}
 		<style>
 			(Inline CSS styles here)
		</style>
	{% endminify %}

...and the resulting CSS output will be stripped of comments, empty space, etc.
    
### Minifying JS

You can wrap any arbitrary `<script>` JS code in the following block tags to minify it:

	{% minify js %}
 		<script>
 			(Inline JS code here)
 		</script>
    {% endminify %}

...and the resulting JS output will be stripped of comments, empty space, etc.
    
## Minify all the things

If you want to minify your entire HTML on the frontend, you can simply wrap your entire `_layout.twig` template (the one that other templates `extends`):

	{% minify %}
			(Entire base HTML/Twig template here)
    {% endminify %}

However, understand the potential performance implications.  On large HTML/CSS/JS blocks minification is not cheap, and if you do it this way, every single HTTP request will spend extra cycles minimizing your entire template.

It works fine for HTML/CSS/JS templates that aren't too huge, but measure any performance impact by profiling your website before and after wrapping the entire `_layout.twig` template to ensure you're not introducing additional latency in the http requests.

On most sites, the overhead that spinning up PHP and Craft takes is the majority of the TTFB (Time To First Byte), and this is not adversely affected by minifying the entire HTML as described here.

## Cache as cache can

A great way to use the `{% minify %}` tags is to wrap them in `{% cache %}` tags:

	{% cache %}
		{% minify %}
			(HTML/Twig code here)
    	{% endminify %}
    {% endcache %}

As with `{% cache %}` tags, you can’t use `{% minify %}` tags outside of top-level `{% block %}` tags within a template that extends another.  [Read more about cache tags](http://buildwithcraft.com/docs/templating/cache)

A nice side-benefit of minifying HTML inside of `{% cache %}` tags is that the text that is stored in the database as a cache is minified itself.

If you've already implemented a caching system to reduce server response time, adding `{% minify %}` tags to the mix is a natural.

## Minify craft.config settings

Minify offers two `craft.config` (set in your `config/general.php`) to allow you to control its behavior:

`disableTemplateMinifying` if set to `true` then Minify will not minify anything

`disableDevmodeMinifying` if set to `true` then Minify will not minify anything if `devMode` is enabled

## Why does my minified HTML/CSS still have linebreaks?

Minify uses the [Minify PHP library](https://github.com/mrclay/minify).  Here's their official explanation:

####Why do the CSS & HTML minifiers add so many line breaks?
TL;DR: Ignore them. They don't add to the output size and if you absolutely want all content on one line you will have to use another tool.

It's rumored that some source control tools and old browsers don't like very long lines. Compressed files with shorter lines are also easier to diff.

Since both Minify classes are regex-based, it would be very difficult/error-prone to count characters then try to re-establish context to add line breaks. Instead, both classes trade 1 space for 1 line break (\n) wherever possible, adding breaks but without adding bytes.

If you can think of another safe & efficient way to limit lines in these two tools without adding bytes, please submit a patch, but this is not something anyone should be worrying about.

## Changelog

### 1.1.1 -- 2016.08.04

* [Improved] Removing dev requirement from composer.json
* [Improved] Updated the README.md

### 1.1.0 -- 2016.03.12

* [Added] The default minify tag now minifies all the things (html, css, js)
* [Added] Added Composer support
* [Improved] Updated the README.md

### 1.0.4 -- 2015.12.28

* Fixed the `releases.json` feed URL
* Changed the Minify config settings from `environmentalVariables` to `craft.config` settings
* Updated the README.md

### 1.0.3 -- 2015.11.23

* Added support for Craft 2.5 new plugin features
* Updated the README.md

### 1.0.2 -- 2015.11.22

* Added `environmentVariables` to let you control Minify's behavior

### 1.0.1 -- 2015.11.22

* Fixed an issue with the minify submodule not being included in the git repo
* Updated the README.md

### 1.0.0 -- 2015.11.21

* Initial release
