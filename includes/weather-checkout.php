<?php
// Function to display weather information on checkout page
function display_weather_info() {
    $location = get_user_location();
    if ($location) {
        $city = $location['city'];
        $country = $location['country'];
        $api_url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $city . ',' . $country . '&appid=e756090c16b4dd0f468fbfacfd465b2e';
        $response = wp_remote_get($api_url);
        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $weather_data = json_decode($body);
            if ($weather_data) {
                echo 'Current Weather: ' . $weather_data->weather[0]->description;
            }
        }
    }
}
add_action('woocommerce_after_checkout_form', 'display_weather_info');
?>
