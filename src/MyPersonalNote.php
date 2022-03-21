<?php

namespace Tanbirahmed\Smartcode;

use FluentCrm\App\Services\Libs\Mailer\Mailer;

class MyPersonalNote {
    protected $actionName = 'my_personal_note';

    protected $priority = 10;

    public function __construct()
    {
        $this->register();
    }

    public function register()
    {
        add_filter('fluentcrm_funnel_blocks', array($this, 'pushBlock'), $this->priority, 2);
        add_filter('fluentcrm_funnel_block_fields', array($this, 'pushBlockFields'), $this->priority, 2);
        add_action('fluentcrm_funnel_sequence_handle_' . $this->actionName, array($this, 'handle'), 10, 4);
    }

    public function pushBlock($blocks, $funnel)
    {
        $this->funnel = $funnel;

        $block = $this->getBlock();
        if($block) {
            $block['type'] = 'action';
            $blocks[$this->actionName] = $block;
        }

        return $blocks;
    }

    public function pushBlockFields($fields, $funnel)
    {
        $this->funnel = $funnel;

        $fields[$this->actionName] = $this->getBlockFields();
        return $fields;
    }

    public function getBlock() {
        return [
            'category'    => __('CRM', 'smartcode'),
            'title'       => __('My Personal Note', 'smartcode'),
            'description' => __('This is my personal note.', 'smartcode'),
            'icon'        => 'fc-icon-writing',
            'settings'    => [
                'type'    => 'SpiderMan'
            ]
        ];
    }

    public function getBlockFields() {

        $noteTypes = [
            'SpiderMan'  => __('Spider Man', 'smartcode'),
            'BatMan'     => __('Bat Man', 'smartcode'),
            'Anaconda'   => __('Anaconda', 'smartcode')
        ];
        $typesOptions = [];
        foreach ($noteTypes as $type => $label) {
            $typesOptions[] = [
                'id'    => $type,
                'title' => $label
            ];
        }
        return [
            'title'     => __('Personal Note', 'smartcode'),
            'sub_title' => __('Adding my personal Information here', 'smartcode'),
            'fields'    => [
                'type'  => [
                    'type'    => 'select',
                    'label'   => __('My Favorite Movie', 'smartcode'),
                    'options' => $typesOptions
                ],
                'title' => [
                    'type'        => 'input-text',
                    'label'       => __('My Activity Title', 'smartcode'),
                    'placeholder' => __('Activity Title', 'smartcode')
                ],
                'is_privacy_policy' => [
                    'check_label'   => __('Send me tips & offers.', 'smartcode'),
                    'type'          => 'yes_no_check'
                ],
                'gender_type' => [
                    'type'    => 'radio',
                    'label'   => __('Select Gender', 'smartcode'),
                    'options' => [
                        [
                            'id'    => 'Girl',
                            'title' => __('Girl', 'smartcode')
                        ],
                        [
                            'id'    => 'Boy',
                            'title' => __('Boy', 'smartcode')
                        ]
                    ]
                ],
                'description' => [
                    'type'    => 'html_editor',
                    'label'   => __('Description', 'smartcode')
                ]
            ]
        ];
    }

    public function handle($subscriber, $sequence, $funnelSubscriberId, $funnelMetric) {
        $title             = sanitize_text_field($sequence->settings['title']);
        $type              = sanitize_text_field($sequence->settings['type']);
        $gender            = $sequence->settings['gender_type'];
        $description       = wp_unslash($sequence->settings['description']);
        $is_privacy_policy = $sequence->settings['is_privacy_policy'];

        $emailBody = $description . ' - I am ' . $gender . '. My Favorite Movie: ' . $type;
        $email     = get_site_option( 'admin_email' );

        $data = [
            'to'        => [
                'email' => $email
            ],
            'subject' => $title . ' - Wanna get Tips?= ' . $is_privacy_policy.'. My Favorite Movie: ' . $type,
            'body'    => $emailBody
        ];

        Mailer::send($data);
    }

}
