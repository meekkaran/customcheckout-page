<?php
// Function to get user location based on IP address
function get_user_location() {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $api_url = 'http://api.ipstack.com/' . $ip_address . '?access_key=94413976a4f4005f394b6adca853b795';
    $response = wp_remote_get($api_url);
    if (is_wp_error($response)) {
        return false;
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);
    return array(
        'city' => $data->city,
        'country' => $data->country_name
    );
}
?>
