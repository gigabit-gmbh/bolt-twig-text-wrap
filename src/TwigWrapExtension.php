<?php

namespace Bolt\Extension\Gigabit\TwigWrap;

use Bolt\Extension\SimpleExtension;

/**
 * TwigWrap extension class.
 *
 * @author Thomas Helmrich <thomas@gigabit.de>
 */
class TwigWrapExtension extends SimpleExtension {

    /**
     * {@inheritdoc}
     */
    protected function registerTwigFilters() {
        return [
            'textWrap' => 'textWrapFilter',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerTwigPaths() {
        return [
            'templates/normal',
            'templates/other' => ['namespace' => 'TwigWrap'],
            'templates/special' => ['namespace' => 'Gigabit', 'position' => 'prepend'],
        ];
    }

    /**
     * Wraps a text that matches the keyword with the given strings
     *
     * @param string $input
     * @param string $keyword
     * @param string $prefix
     * @param string $affix
     *
     * @return string
     */
    public function textWrapFilter($input, $keyword, $prefix = '', $affix = '') {
        mb_internal_encoding("UTF-8");

        $keywordPos = mb_stripos($input, $keyword);
        if ($keywordPos === false) {
            return $input;
        }

        $inputLength = mb_strlen($input);

        $inputStart = mb_substr($input, 0, $keywordPos);

        $startingSpacePos = mb_strripos($inputStart, ' ');
        if ($startingSpacePos === false) {
            $startingSpacePos = -1;
        }
        $matchingWord = mb_substr($input, $startingSpacePos+1, $inputLength);

        $endingSpacePos = $this->stripos_array($matchingWord, array(' ', ',', '.', '!', '?', ';', '""'));
        if ($endingSpacePos === false) {
            $endingSpacePos = strlen($matchingWord);
        }
        $matchingWord = mb_substr($matchingWord, 0, $endingSpacePos);

        $wrappedMatching = $prefix.$matchingWord.$affix;
        return str_replace($matchingWord, $wrappedMatching, $input);
    }

    protected function stripos_array($haystack, $needles) {
        if (is_array($needles)) {
            $results = array();
            foreach ($needles as $str) {
                if (is_array($str)) {
                    $pos = $this->stripos_array($haystack, $str);
                } else {
                    $pos = mb_stripos($haystack, $str);
                }
                if ($pos !== false) {
                    array_push($results, $pos);
                }
            }
            return ((!empty($results) ? min($results) : 0));
        } else {
            return mb_stripos($haystack, $needles);
        }
    }

}
