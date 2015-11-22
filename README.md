# Minify plugin for Craft CMS

A simple plugin that allows you to minify blocks of HTML, CSS, and JS inline in Craft CMS templates

**Installation**

1. Unzip file and place `minify` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/khalwat/minify.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins

##Configuring Minify

There is nothing to configure

##Using the Minify plugin in your templates

Minify adds several block tags for minifying HTML, CSS, and JS inline in your templates.  Minify does **not** minify external CSS or JS files.  Use `grunt` or `gulp` task runners to set up a workflow that minimizes these as part of your build process.

You can nest any number of the various `{% minify %}` tags as you wish.

##Why minify inline HTML/CSS/JS code?

You already properly `gzip` output via `mod_deflate` with Apache or by enabling compression with `Nginx` for optimal delivery on production.  You already use a task runner like `grunt` or `gulp` or CodeKit to minimize static resources like CSS/JS files.  What's the point of minifying HTML/CSS/JS inline?

Twig does provide the `{% spaceless %}` tag, but it is not intended for use as a way to properly minify HTML/CSS/JS code.

Firstly, you want to keep HTML/CSS/JS comments and a nice hierarchical structure to your code, with plenty of readable whitespace for development, but want all of this stripped out of the HTML/CSS/JS that is served to your frontend.

Secondly, not all CSS/JS can or should be in static asset files.  Sometimes you need inline Javascript for efficiency reasons, or if you're using `JSON-LD` for Google Structured Data/SEO purposes inline in your HTML files.  You may also want to be able to use the Craft templating engine in your CSS/JS itself.

Enter Minify.

### Minifying HTML

You can wrap any arbitrary HTML/Twig code in the following block tags to minify it:

	{% minify html %}
		(HTML/Twig code here)
    {% endminify %}

...and the resulting HTML output will be stripped of comments, empty space, etc.  A shortcut for HTML minification block tags is simply:

	{% minify %}
		(HTML/Twig code here)
    {% endminify %}
    
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
    
##Just because you can doesn't mean you should

Yes, you can simply wrap your entire `_layout.twig` template in:

	{% minify %}
			(Massive HTML/Twig template here)
    {% endminify %}

...but understand that you probably shouldn't.  The reason is that minification is not cheap; and if you do it this way, every single HTTP request will spend extra cycles minimizing your entire template.

Instead, best practice use of the `{% minify %}` tags is to wrap them in `{% cache %}` tags:

	{% cache %}
		{% minify html %}
			(HTML/Twig code here)
    	{% endminify %}
    {% endcache %}

As with `{% cache %}` tags, you can’t use `{% minify %}` tags outside of top-level `{% block %}` tags within a template that extends another.  [Read more about cache tags](http://buildwithcraft.com/docs/templating/cache)

A nice side-benefit of minifying HTML inside of `{% cache %}` tags is that the text that is stored in the database as a cache is minified itself.

##Minify environmentVariables

Minify offers two `environmentVariables` (set in your `config/general.php`) to allow you to control its behavior:

**disableTemplateMinifying** if set to `true` then Minify will not minify anything

**disableDevmodeMinifying** if set to `true` then Minify will not minify anything if `devMode` is enabled


## Changelog

### 1.0.2 -- 2015.11.21

* Added `environmentVariables` to let you control Minify's behavior

### 1.0.1 -- 2015.11.21

* Fixed an issue with the minify submodule not being included in the git repo
* Updated the README.md

### 1.0.0 -- 2015.11.21

* Initial release
