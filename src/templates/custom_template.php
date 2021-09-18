<?php
get_header();
$syndicationInfo = get_post_meta(get_the_ID(), 'syndication_info', true);
$templateNumber = \BiwyzeTourinsoft\Repositories\OptionsRepository::getOption('elementor_template_'.$syndicationInfo['syndic_id']);

if(shortcode_exists('elementor-template')) {
    echo do_shortcode('[elementor-template id="' .$templateNumber. '"]');
}else if(shortcode_exists('INSERT_ELEMENTOR')) {
    echo do_shortcode('[INSERT_ELEMENTOR id="' .$templateNumber. '"]');
}
get_footer();
?>