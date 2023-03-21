<?php
/*
Plugin Name: Shortcode for Product Variations and Description
Plugin URI: https://example.com/
Description: A shortcode that displays the variations and description of a product on the same line.
Version: 1.0
Author: Hossam Omran
License: GPL2
*/

// Register shortcode
add_shortcode( 'product_variations_and_description', 'product_variations_and_description_shortcode');

// Shortcode function
function product_variations_and_description_shortcode( $atts ) {
    // Get the product ID
    global $product;
    $product_id = $product->get_id();
    if (!has_term('pacchetti', 'product_cat', $product_id)) {
        return '';
    }
    $product = wc_get_product($product_id);
    $product_price = $product->get_price();
    // Get the variations of the product
    $variations = $product->get_available_variations();
    // Output variations and description
    ob_start();
    if ( ! empty( $variations ) ) {
        echo '<div class="product-price">';
        echo '<span class="variation-price_starting" > starting at</span>';
        echo '<span class="variation-price_bold">'.  $product_price . ' ' . get_woocommerce_currency_symbol() . '</span>';
        echo '</div>';
        echo '<div class="wpc-variation-radio-buttons">';
        // Loop through the variations
        foreach ( $variations as $variation ) {
            // Get the variation ID
            $variation_id = $variation['variation_id'];
            // Get the custom name for the variation
            $custom_name = get_post_meta( $variation_id, 'woovr_name', true );
            // Get custom products variations ids
            $custom_custom = get_post_meta( $variation_id, '_pwgc_product_ids', true );
            // Use the custom name if available, otherwise use the default variation name
            $variation_name = $custom_name ? $custom_name : '';
            $tickets_numbers = get_post_meta( $variation_id, 'custom_select', true );
            $ticket_area = get_post_meta( $variation_id, 'custom_textarea_ring1', true );
            $ticket_area2 = get_post_meta( $variation_id, 'custom_textarea_ring2', true );
            $ticket_muse= get_post_meta( $variation_id, 'text_area_Museo', true );
            $text_area_Tour= get_post_meta( $variation_id, 'text_area_Tour', true );
            
            if ($product->is_type('variable') && method_exists($product, 'get_variation_attribute_name')) {
                $variation_name = $product->get_variation_attribute_name('pa_variation');
            }
            // Output the radio button, variation name, variation description, and variation price
            echo '<div class="main">';
            echo '<input type="radio" name="variation_id" value="' . $variation_id . '" data-product-id="' . $variation_id . '"> ';
            echo '<div class="input_price">';
            echo '<div class="details">';
            echo '<h6 class="variation-name">' .'Package'.'<span id="package"> '. $variation_name .'</span>'. '</h6> ';
            echo '<span class="variation-price">' . $variation['display_price'] . ' ' . get_woocommerce_currency_symbol() . '</span>';
            echo '</div>';
            echo '</div>';
            echo '<div class="variation_descreption">';
            // echo '<span >' . $variation['variation_description'] . '</span> '; //show the description on each variation dynamically if entered.
            echo '<div style="justify-content: center;align-items: center" class="variation_new_design">';
            echo '<div class="variation-inner" style="justify-content: center;align-items: center">';
            echo ' <img src="https://soccergo.it/wp-content/uploads/2023/03/seats.png" />';
            echo ' <div class="title" style="margin-left: 10px">';
            echo ' <strong>'. $tickets_numbers .'Biglietti partita</strong>';
            echo '<p style="margin: 0">'.  $ticket_area.'</p>';
            echo '<p style="margin: 0">'.  $ticket_area2.'</p>';
            echo '</div>';
            echo '</div>';
            echo '<div class="variation-inner" style="justify-content: center;align-items: center">';
            echo '  <img src="https://soccergo.it/wp-content/uploads/2023/03/beds.png">';
            echo '<div class="title" style="margin-left: 10px">';
            echo '  <strong>Hotel 4 stelle</strong>';
            echo ' <p style="margin: 0">1 notte per 2 persone</p>';
            echo ' </div>';
            echo '  </div>';
            if($ticket_muse!=""){;
            echo '<div class="variation-inner" style="justify-content: center;align-items: center">';
            echo '<img src="https://soccergo.it/wp-content/uploads/2023/03/beds.png">';
            echo '<div class="title" style="margin-left: 10px"> ';
            echo '<strong>Museo dell’Inter</strong>';
            echo '<p style="margin: 0">'. $ticket_muse.'</p>';
            echo '</div>';
            echo '</div>';
             } ;
            if($text_area_Tour!=""){;
            echo '<div class="variation-inner" style="justify-content: center;align-items: center">';
            echo '<img src="https://soccergo.it/wp-content/uploads/2023/03/Path-138.png">';
            echo ' <div class="title" style="margin-left: 10px">';
            echo '<strong>Tour dello stadio</strong>';
            echo ' <p style="margin: 0">'. $text_area_Tour.'</p>';
            echo '</div>';
            echo '</div>';
           
             };
             echo ' <div class="variation-inner" style="justify-content: center;align-items: center">';
             echo ' <img src="https://soccergo.it/wp-content/uploads/2023/03/Group-154.png">';
             echo '  <div class="title" style="margin-left: 10px">';
             echo '<a id="show-popup-' . $variation_id . '" class="add_popup" data-product-id="' . $variation_id . '"> <strong>Events list</strong></a>';
             echo '<div id="event-list-popup-' . $variation_id . '" class="event-list-popup" style="display:none;">';
                echo ' <div class="title"><strong>Elenco partite disponibli</strong></div>';
                echo ' <div class="title"><span>Weekend NeroAzzurro</span> <span class="bold_text">Pacchetto</span></div>';
                echo ' <div class="content">';
                echo '<ul>';
                foreach($custom_custom as $mproduct){
                    $custom_product=$mproduct; //products related to this variation 
                    $custom_product_name = wc_get_product( $custom_product); //product_id related to this variation
                    $custom_produc2= $custom_product_name->get_title(); //product name related to this variation
                    $custom_date=  get_post_meta($custom_product, 'WooCommerceEventsDate', true );
                    $custom_hour=  get_post_meta($custom_product, 'WooCommerceEventsHour', true );
                    $custom_minute=  get_post_meta($custom_product, 'WooCommerceEventsMinutes', true );
                    $date_timestamp = strtotime($custom_date); 
                    $day_of_week = date('D', $date_timestamp);
                    $first_three_letters = substr($day_of_week, 0, 3);
                    $date_timestamp = strtotime($custom_date);
                    $formatted_date = date('j/n/Y', $date_timestamp);
                    echo '<li> <span class="day_selector"> '.$first_three_letters.'  </span> <span class="date_selector"> '
                    .$formatted_date.',</span> <span class="time_selector"> '
                    .$custom_hour.':'. $custom_minute.'</span><span class="match_selector">  '
                    .$custom_produc2.' </span></li>';
                    echo '<hr>';
                  
                }
                echo '</ul>';
                echo '</div>';
                echo '<button id="close-popup">OK</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
        }
        echo '</div>';
        echo '<br>';

    }
   
    echo '<div class="button_single_text">';
    echo '<h4 class="button_single_text_details">  Pacchetto Personale  <span class=""inner_price>'.$product_price . '</span>  ' . get_woocommerce_currency_symbol() . '</h4>';
    echo '</div>';
   
   
 
      
$output = ob_get_clean();   
    return $output;
}

function my_plugin_scripts() {
    // Enqueue jQuery library
    wp_enqueue_script('jquery');
    // Enqueue script file that updates the variation ID input field
    wp_enqueue_script('my-plugin-script', plugin_dir_url(__FILE__) . 'js/variation.js', array('jquery'), '1.0', true);
    wp_enqueue_style('my-plugin-style', plugin_dir_url(__FILE__) . 'css/single_product.css', array(), '1.0', 'all');
  }
  
  add_action('wp_enqueue_scripts', 'my_plugin_scripts');

?>

