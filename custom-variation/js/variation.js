jQuery(document).ready(function ($) {
  jQuery(".button_single_text").appendTo(".quantity.hidden");
  // Add the event details HTML to the popup content
  $(".add_popup").attr('onclick', 'show_popup()');
  // Listen for radio button changes
  $('input[type="radio"][name="variation_id"]').on('change', function () {
    // Get the selected variation ID
    var variation_id = $(this).val();
    // Update the hidden input field value
    $('input.variation_id').val(variation_id);
  });
  // get the form element
  const form = document.querySelector('#pwgc-purchase-container');
  // get the buy button element
  const buyButton = document.querySelector('.single_add_to_cart_button');
  // add event listener to the form to check when required fields are filled out
  form.addEventListener('change', () => {
    // check if all required fields are filled out
    const requiredFields = form.querySelectorAll('[required]');
    const allFieldsFilled = [...requiredFields].every(field => field.value !== '');
    // if all required fields are filled out, enable the buy button, otherwise disable it
    if (allFieldsFilled) {
      buyButton.removeAttribute('disabled');
      $('.single_add_to_cart_button').removeClass('disabled');
      $('.single_add_to_cart_button').removeClass('wc-variation-selection-needed');
      $('.woocommerce-variation-add-to-cart').removeClass('woocommerce-variation-add-to-cart-disabled');
      $('.woocommerce-variation-add-to-cart').addClass('woocommerce-variation-add-to-cart-enabled');
    } else {
      buyButton.setAttribute('disabled', '');
    }
  });

});

//show popup function
function show_popup() {
  var prevPopup = null;


  //open popup
  jQuery(".add_popup").click(function () {
   
    var popupId = "#event-list-popup-" + jQuery(this).data('product-id');
    var currentPopup = jQuery(popupId); // store the current popup element in a variable

    if (prevPopup !== null) {
      prevPopup.css('z-index', 'auto'); // reset the z-index property of the previous popup
      prevPopup.hide(); // hide the previous popup
    }
    currentPopup.css('z-index', '9999'); // set the z-index property of the current popup element to a high value
    jQuery(popupId).show();

    prevPopup = currentPopup; // set the current popup element as the new previous popup element

    // Pass the popup ID to the "OK" button click event handler
    jQuery(popupId + " #close-popup").click(function () {
      jQuery(popupId).hide(); // hide the specific popup
    });
  });

};

function add_class() {
  jQuery("#event-list-popup").addClass("event-list-popup");

}
jQuery(document).ready(function () {
  // Call the show_popup() function when the page is loaded
  show_popup();
  add_class();
});
//close the popup if click anywhere outside the container
jQuery(document).mouseup(function (e) {

  var container = jQuery(".event-list-popup");

  // if the target of the click isn't the container nor a descendant of the container
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    container.hide();
  }

});