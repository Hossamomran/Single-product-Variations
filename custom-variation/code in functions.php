<?php  //Add custom field for variations in single product page Edit.
    add_action( 'woocommerce_product_after_variable_attributes', 'custom_field_creator', 10, 3 );
    function custom_field_creator( $loop, $variation_data, $variation ) {
    
     woocommerce_wp_select(
    		array(
    			'id'            => 'select_field[' . $loop . ']',
    			'label'         => ' Biglietti partita',
    			'wrapper_class' => 'form-row show_if_variation_virtual',
    			'description'   => ' ADD Biglietti partita',
    			'value'         => get_post_meta(  $variation->ID, 'custom_select', true ),
    			'options'       => array(
    				'1' => '1',
    				'2' => '2',
    				'3' => '3',
                    '5'=> '5',
                    '6'=> '6',
                    '7'=> '7',
                    '8'=> '8',
                    '9'=> '9',
                    '10'=> '10'
    			)
    		)
    	);
        // Textarea for tickets position
    	woocommerce_wp_textarea_input(
    		array(
    			'id'            => 'textarea_field1[' . $loop . ']',
    			'label'         => 'Biglietti partita Description (enter first ring (1º anello ) if not leave it empty) OR Area VIP IM HOSPITALITY',
    			'wrapper_class' => 'form-row show_if_variation_virtual', //show only if product is virtual 
    			'value'         => get_post_meta( $variation->ID, 'custom_textarea_ring1', true ),
    		)
    	);
           // Textarea for tickets position
           woocommerce_wp_textarea_input(
    		array(
    			'id'            => 'textarea_field2[' . $loop . ']',
    			'label'         => 'Biglietti partita Description (enter second ring (2º anello ) if not leave it empty)',
    			'wrapper_class' => 'form-row show_if_variation_virtual', //show only if product is virtual 
    			'value'         => get_post_meta( $variation->ID, 'custom_textarea_ring2', true ),
    		)
    	);
             // Textarea for nights and people
          woocommerce_wp_textarea_input(
    		array(
    			'id'            => 'text_area_nights[' . $loop . ']',
    			'label'         => ' ? notte per  ? persone Example 1 notte per 2 persone',
    			'wrapper_class' => 'form-row show_if_variation_virtual', //show only if product is virtual 
    			'value'         => get_post_meta( $variation->ID, 'text_area_nights', true ),
    		)
    	);
          woocommerce_wp_textarea_input(
    		array(
    			'id'            => 'text_area_Museo[' . $loop . ']',
    			'label'         => ' Museo dell’Inter Example 2 biglietti',
    			'wrapper_class' => 'form-row show_if_variation_virtual', //show only if product is virtual 
    			'value'         => get_post_meta( $variation->ID, 'text_area_Museo', true ),
    		)
    	);
         woocommerce_wp_textarea_input(
    		array(
    			'id'            => 'text_area_Tour[' . $loop . ']',
    			'label'         => ' Tour dello stadio Example 2 biglietti',
    			'wrapper_class' => 'form-row show_if_variation_virtual', //show only if product is virtual 
    			'value'         => get_post_meta( $variation->ID, 'text_area_Tour', true ),
    		)
    	);
    
    };




add_action( 'woocommerce_save_product_variation', 'rudr_save_fields', 10, 2 );

function rudr_save_fields( $variation_id, $loop ) {
    $select_field = ! empty( $_POST[ 'select_field' ][ $loop ] ) ? $_POST[ 'select_field' ][ $loop ] : '';
    $textarea_field1 = ! empty( $_POST[ 'textarea_field1' ][ $loop ] ) ? $_POST[ 'textarea_field1' ][ $loop ] : '';
    $textarea_field2 = ! empty( $_POST[ 'textarea_field2' ][ $loop ] ) ? $_POST[ 'textarea_field2' ][ $loop ] : '';
    $textarea_nights = ! empty( $_POST[ 'text_area_nights' ][ $loop ] ) ? $_POST[ 'text_area_nights' ][ $loop ] : '';
    $textarea_Museo = ! empty( $_POST[ 'text_area_Museo' ][ $loop ] ) ? $_POST[ 'text_area_Museo' ][ $loop ] : '';
    $text_area_Tour = ! empty( $_POST[ 'text_area_Tour' ][ $loop ] ) ? $_POST[ 'text_area_Tour' ][ $loop ] : '';
    
    //save data into variations meta data
    update_post_meta( $variation_id, 'custom_select', sanitize_text_field( $select_field ) );
    update_post_meta( $variation_id, 'textarea_field1', sanitize_textarea_field( $textarea_field1 ) );
    update_post_meta( $variation_id, 'textarea_field2', sanitize_textarea_field( $textarea_field2 ) );
    update_post_meta( $variation_id, 'text_area_nights', sanitize_textarea_field(  $textarea_nights ));
    update_post_meta( $variation_id, 'text_area_Museo', sanitize_textarea_field( $textarea_Museo ) );
    update_post_meta( $variation_id, 'text_area_Tour', sanitize_textarea_field( $text_area_Tour ) );
    
}

add_filter( 'woocommerce_available_variation', function( $variation ) {
    //view custom fields variations
    $variation[ 'custom_select' ] = get_post_meta( $variation[ 'variation_id' ], 'custom_select', true );
    $variation[ 'textarea_field1' ] = get_post_meta( $variation[ 'variation_id' ], 'textarea_field1', true );
    $variation[ 'textarea_field2' ] = get_post_meta( $variation[ 'variation_id' ], 'textarea_field2', true );
    $variation[ 'text_area_nights' ] = get_post_meta( $variation[ 'variation_id' ], 'text_area_nights', true );
    $variation[ 'text_area_Museo' ] = get_post_meta( $variation[ 'variation_id' ], 'text_area_Museo', true );
    $variation[ 'text_area_Tour' ] = get_post_meta( $variation[ 'variation_id' ], 'text_area_Tour', true );
    
    return $variation;

} );

