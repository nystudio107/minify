<?php
namespace Craft;

/**
 * Class Minify_TokenParser
 */
class Minify_TokenParser extends \Twig_TokenParser
{
    // Public Methods
    // =========================================================================

    /**
     * @return string
     */
    public function getTag()
    {
        return 'minify';
    }

    /**
     * Parses {% cache %}...{% endcache %} tags.
     *
     * @param \Twig_Token $token
     *
     * @return Cache_Node
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $attrSet = false;

        $attributes = array(
            'html' => false,
            'css' => false,
            'js' => false,
        );

        if ($stream->test(\Twig_Token::NAME_TYPE, 'html'))
        {
            $attributes['html'] = true;
            $stream->next();
            $attrSet = true;
        }

        if ($stream->test(\Twig_Token::NAME_TYPE, 'css'))
        {
            $attributes['css'] = true;
            $stream->next();
            $attrSet = true;
        }

        if ($stream->test(\Twig_Token::NAME_TYPE, 'js'))
        {
            $attributes['js'] = true;
            $stream->next();
            $attrSet = true;
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        $nodes['body'] = $this->parser->subparse(array($this, 'decideCacheEnd'), true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new Minify_Node($nodes, $attributes, $lineno, $this->getTag());
    }

    /**
     * @param \Twig_Token $token
     *
     * @return bool
     */
    public function decideCacheEnd(\Twig_Token $token)
    {
        return $token->test('endminify');
    }
}
