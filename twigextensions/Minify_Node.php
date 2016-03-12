<?php
namespace Craft;

/**
 * Class Minify_Node
 */
class Minify_Node extends \Twig_Node
{
    // Properties
    // =========================================================================


    // Public Methods
    // =========================================================================

    /**
     * @param \Twig_Compiler $compiler
     *
     * @return null
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $html = $this->getAttribute('html');
        $css = $this->getAttribute('css');
        $js = $this->getAttribute('js');

        $compiler
            ->addDebugInfo($this);

        $compiler
            ->write("ob_start();\n")
            ->subcompile($this->getNode('body'))
            ->write("\$_compiledBody = ob_get_clean();\n");

        if ($html)
        {
            $compiler
                ->write("echo \Craft\craft()->minify->htmlMin(\$_compiledBody);\n");
        }
        elseif ($css)
        {
            $compiler
                ->write("echo \Craft\craft()->minify->cssMin(\$_compiledBody);\n");
        }
        elseif ($js)
        {
            $compiler
                ->write("echo \Craft\craft()->minify->jsMin(\$_compiledBody);\n");
        }
        else
        {
            $compiler
                ->write("echo \Craft\craft()->minify->minify(\$_compiledBody);\n");
        }

    }
}
