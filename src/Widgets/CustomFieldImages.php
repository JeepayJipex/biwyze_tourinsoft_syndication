<?php

namespace BiwyzeTourinsoft\Widgets;

class CustomFieldImages extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'tourinsoft-custom-field-image';
    }

    public function get_title()
    {
        return 'Tourinsoft Images Grid ';
    }

    public function get_icon()
    {
        return 'eicon-gallery-masonry';
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
            'display_type',
            [
                'label' => 'Type de grille',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'flex',
                'options' => [
                    'flex' => 'Grille',
                ],
                'selectors' => [
                    '{{WRAPPER}} .images' => 'display: {{VALUE}}; flex-wrap: wrap; justify-content: center;',
                ],
            ]
        );
        $this->add_responsive_control(
            'column_number',
            [
                'label' => 'Nombre de colonnes',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'colonnes' => [
                        'min' => 1,
                        'max' => 12,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 4,
                    'unit' => 'colonnes',
                ],
                'tablet_default' => [
                    'size' => 2,
                    'unit' => 'colonnes',
                ],
                'mobile_default' => [
                    'size' => 1,
                    'unit' => 'colonnes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .image' => 'width: calc(100% / {{SIZE}});',
                ],
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => 'Hauteur des images',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 1200,
                'step' => 10,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .image' => "height: {{VALUE}}px;"
                ]
            ]
        );
        $this->add_control(
            'gap',
            [
                'label' => 'Espace entre les éléments',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .image' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $metaValue = get_post_meta(get_the_ID(), $settings['field_name'], true);
        ?>
        <div class="images">
            <?php
            if (!$metaValue || (is_array($metaValue) && count($metaValue) === 0)):
                for ($i = 0; $i < 12; $i++):
                    ?>
                    <div class="image">
                        <a href="https://via.placeholder.com/<?= rand(150, 400) ?>" style="display:block; background-size: cover!important;width: 100%; height: 100%; background: url('https://via.placeholder.com/<?= rand(150, 400) ?>') center no-repeat;"></a>
                    </div>
                <?php endfor;
            else:
                foreach ($metaValue as $image):
                    ?>
                    <div class="image">
                        <a href="<?= $image[0] ?? "https://via.placeholder.com/150" ?>" style="display: block; background-size: cover!important;width: 100%; height: 100%; background: url('<?= $image[0] ?? "https://via.placeholder.com/150" ?>') center no-repeat;"></a>
                    </div>
                <?php endforeach; endif; ?>
        </div>
        <?php
    }
}