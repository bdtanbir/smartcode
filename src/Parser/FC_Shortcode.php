<?php
namespace Tanbirahmed\Smartcode\Parser;

class FC_Shortcode {

    public function cs_data() {
        $data = apply_filters('cs_data_filter', [
            'name' => apply_filters('cs_data_filter_name', 'Tanbir', 10, 1),
            'email' => 'tanbir.authlab@gmail.com'
        ]);
        return $data;
    }

    public function parse($templateString) {
        $result = [];
        $isSingle = false;

        if (!is_array($templateString)) {
            $isSingle = true;
        }

        foreach ((array)$templateString as $key => $string) {
            $result[$key] = $this->parseShortcode($string);
        }

        if ($isSingle) {
            return reset($result);
        }

        return $result;
    }

    public function parseShortcode($string) {
        return preg_replace_callback('/({{|##)+(.*?)(}}|##)/', function ($matches) {
            return $this->replace($matches);
        }, $string);
    }

    public function replace($matches)
    {
        $matches[2] = trim($matches[2]);
        $matched = explode('.', $matches[2]);
        $dataKey = trim(array_shift($matched));
        $valueKey = trim(implode('.', $matched));
        $valueKeys = explode('|', $valueKey);
        $valueKey = $valueKeys[0];
        $defaultValue = '';
        if (isset($valueKeys[1])) {
            $defaultValue = trim($valueKeys[1]);
        }
        switch ($dataKey) {
            case 'tanbir':
                return $this->getTanbirValue($valueKey, $defaultValue);
            default:
                return $defaultValue;
        }

    }

    public function getTanbirValue($valueKey, $defaultValue) {
        switch ($valueKey) {
            case 'name':
                return 'Tanbir';
            case 'email':
                return 'tanbirsylhet20@gmail.com';
            case 'birthday':
                return '15-11-2000';
            default:
                return $defaultValue;
        }
    }
}