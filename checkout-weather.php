<?php
/*
Plugin Name: Custom Checkout Plugin
Description: Customizes WooCommerce checkout with weather information.
Version: 1.0
*/

// Function to display weather information on checkout page
function display_dynamic_weather_info() {
    $order_id = WC()->session->get('order_awaiting_payment');
    $order = wc_get_order($order_id);

    if (!$order) {
        return;
    }

    $shipping_city = $order->get_shipping_city();
    $shipping_country = $order->get_shipping_country();

    if (empty($shipping_city) || empty($shipping_country)) {
        return;
    }

    $api_url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($shipping_city . ',' . $shipping_country) . '&APPID=e756090c16b4dd0f468fbfacfd465b2e';

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        error_log('Weather API request failed: ' . $response->get_error_message());
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $weather_data = json_decode($body);

    if ($weather_data) {
        echo 'Current Weather: ' . $weather_data->weather[0]->description;
    } else {
        error_log('Failed to parse weather data: ' . $body);
    }
}
add_action('woocommerce_after_checkout_form', 'display_dynamic_weather_info');

