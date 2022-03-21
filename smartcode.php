<?php
/*
Plugin Name:  SmartCode
Plugin URI:
Description:  smartcode
Version:      2.5.8
Author:       Newsletter Team by Fluent CRM
Author URI:   https://fluentcrm.com
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  smartcode
Domain Path:  /language
*/
require_once 'vendor/autoload.php';
defined('ABSPATH') or die;
define('SMARTCODE_PLUGIN_VERSION', '1.0');
define( 'FC_FILE', __FILE__ );
define( 'FC_PATH', dirname( FC_FILE ) );
define( 'FC_PARSER', FC_PATH . '/Parser' );


use Tanbirahmed\Smartcode\Parser\FC_Shortcode;
use Tanbirahmed\Smartcode\MyPersonalNote;
class SmartCode {
    protected $model;
    protected $mypersonalnote;
    public function __construct()
    {
        $this->model = new FC_Shortcode();
        $this->mypersonalnote = new MyPersonalNote();
        add_action('init', [$this, 'tanbir_sc_plugin_init']);
        add_filter('cs_data_filter_name', [$this, 'tanbir_filter_modify']);
        add_filter('fluentcrm_extended_general_smart_codes', [$this, 'fc_addshortcode']);
    }

    public function fc_addshortcode($smartcode) {

        $smartcode[] = [
            'key'        => 'fc_tanbir',
            'title'      => __('FC Tanbir', 'fluent-crm'),
            'shortcodes' => apply_filters('fluentcrm_tanbir_shortcodes', [
                '{{tanbir.name}}' => __('Tanbir Name', 'fluent-crm'),
                '{{tanbir.email}}' => __('Tanbir Email', 'fluent-crm')
            ])
        ];
        return $smartcode;

    }

    public function tanbir_filter_modify($name) {
        $name = $name . ' = Modified';
        return $name;

    }

    public function tanbir_sc_plugin_init() {
        $text = 'hello {{tanbir.name}} and my email is {{tanbir.email}}';

//        error_log(print_r($this->model->cs_data(), 1));
//        die($this->model->parse($text));
//        error_log(print_r($this->model->parse($text), 1));


    }
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new SmartCode();
        }

        return $instance;
    }
}
SmartCode::init();





