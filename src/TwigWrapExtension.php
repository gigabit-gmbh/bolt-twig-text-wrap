<?php

namespace Bolt\Extension\Gigabit\TwigWrap;

use Bolt\Extension\SimpleExtension;

/**
 * TwigWrap extension class.
 *
 * @author Thomas Helmrich <thomas@gigabit.de>
 */
class TwigWrapExtension extends SimpleExtension
{

    /**
     * {@inheritdoc}
     */
    protected function registerTwigFilters()
    {
        return [
            'textWrap' => 'textWrapFilter',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerTwigPaths()
    {
        return [
            'templates/normal',
            'templates/other'   => ['namespace' => 'TwigWrap'],
            'templates/special' => ['namespace' => 'Gigabit', 'position' => 'prepend']
        ];
    }

    /**
     * Wraps a text that matches the keyword with the given strings
     *
     * @param string $input
     * @param string $keyWord
     * @param string $prepend
     * @param string $append
     *
     * @return string
     */
    public function textWrapFilter($input, $keyWord, $prepend, $append)
    {



        return strtolower($input);
    }

}
