<?php

namespace BiwyzeTourinsoft\Widgets;

class CustomFieldItemList extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'tourinsoft-custom-field-item-list';
    }

    public function get_title()
    {
        return 'Tourinsoft Item List ';
    }

    public function get_icon()
    {
        return 'eicon-editor-list-ul';
    }

    public function get_categories()
    {
        return ['tourinsoft'];
    }

    public function get_script_depends()
    {
    }

    public function get_style_depends()
    {
    }

    protected function _register_controls()
    {
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
            'list_title',
            [
                'label' => 'Titre de la liste',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 'Nom du champ de syndication à afficher',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => 'Couleur du titre',
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Typographie du titre',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'list_item_color',
            [
                'label' => 'Couleur du texte des éléments',
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'element_typographie',
                'label' => 'Typographie d\'un élément',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .element',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $metaValue = get_post_meta(get_the_ID(), $settings['field_name'], true);
        if(!$metaValue) return;
        if (!is_array($metaValue)) $metaValue = [$metaValue];
        ?>
        <div>
            <h5 class="title"><?= $settings['list_title'] ?></h5>
            <hr>
            <ul>
                <?php foreach ($metaValue as $element): ?>
                    <li class="element"><?php echo str_replace(['\n'], ['<br/>'],$element); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}