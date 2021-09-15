<?php

namespace BiwyzeTourinsoft\Widgets;

class CustomField extends \Element\Widget_Base
{
    public function get_name() {
        return 'tourinsoft-custom-field';
    }

    public function get_title() {
        return 'Tourinsoft Custom Field';
    }

    public function get_icon() {
        return 'fa fa-code';
    }

    public function get_categories() {
        return ['tourinsoft'];
    }

    public function get_script_depends() {}

    public function get_style_depends() {}

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Content',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => 'Contenu',
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'input_type' => 'url',
                'placeholder' => __( 'https://your-link.com', 'plugin-name' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        return 'test';
    }

    protected function _content_template() {}
}