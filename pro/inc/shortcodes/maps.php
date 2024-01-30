<?php

add_shortcode('mesmerize_maps', 'mesmerize_maps');


Kirki::add_field('one_page_express', array(
    'type'     => 'text',
    'settings' => 'mesmerize_maps_api_key',
    'label'    => __('Map api key', 'mesmerize'),
    'section'  => 'page_content_settings',
    'transport'=> 'postMessage',
    'default'  => "",
));

function mesmerize_maps($atts = array())
{
    $content = "";

    if (isset($atts['shortcode'])) {
        $content = do_shortcode("[" . html_entity_decode(html_entity_decode($atts['shortcode'])) . "]");
    } else {
        $atts = shortcode_atts(
            array(
                'id'      => md5(uniqid("mesmerize-map-", true)),
                'zoom'    => '65',
                'type'    => 'ROADMAP',
                'lat'     => "",
                'lng'     => "",
                'address' => "New York",
            ),
            $atts
        );

        $atts['zoom'] = round($atts['zoom'] * 0.21);
        $key       = get_theme_mod('mesmerize_maps_api_key', false);
        $key       = (is_string($key) && !empty($key)) ? $key : false;



        $base_url = 'https://www.google.com/maps/embed/v1/place';
        $no_api_base_url = 'https://maps.google.com/maps';


        if ($key) {
        $map_url = add_query_arg(
            array(
                'key' => $key,
                'q' => $atts['address'],
                'zoom' => $atts['zoom'],
            ),
            $base_url
        );
        } else {

            $map_url = add_query_arg(
                array(
                    'q' => $atts['address'],
                    'z' => $atts['zoom'],
                    'output' => 'embed',
                    'iwloc' => 'near'
                ),
                $no_api_base_url
            );
        }


        $center = ($atts['lat'] && $atts['lng']) ? trim($atts['lat']) . "," . trim($atts['lng']) : null;
        if ($center) {

            if ($key) {
            $map_url = add_query_arg(
                array(
                    'center' => $center,
                ),
                $map_url
            );
            } else {
                $map_url = add_query_arg(
                    array(
                        'll' => $center,
                    ),
                    $map_url
                );
            }
        }

        ob_start();

    ?>
        <div class="mesmerize-google-maps" style="width:100%">
            <iframe style="width:100%; height:100%;min-height:inherit;display:block;" src="<?php echo esc_url($map_url); ?>"></iframe>
        </div>
    <?php
        $content = ob_get_clean();
    }

    return $content;
}
