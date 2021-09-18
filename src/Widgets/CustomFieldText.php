<?php

namespace BiwyzeTourinsoft\Widgets;

class CustomFieldText extends \Elementor\Widget_Base
{
    public function get_name() {
        return 'tourinsoft-custom-field-text';
    }

    public function get_title() {
        return 'Tourinsoft Text Field ';
    }

    public function get_icon() {
        return 'eicon-custom';
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
            'field_name',
            [
                'label' => 'Nom du champ',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'SyndicObjectName',
                'placeholder' => 'Nom du champ de syndication à afficher',
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => 'Alignement',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => 'Gauche',
                    'center'  => 'Centre',
                    'right'  => 'Droite',
                ],
                'selectors' => [
                    '{{WRAPPER}} .text' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => 'Couleur',
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => 'Typographie',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $metaValue = get_post_meta(get_the_ID(), $settings['field_name'], true);
        if($metaValue === '') $metaValue = 'Contenu du champ';
        echo '<p class="text">'. $metaValue . '</p>';
    }
}