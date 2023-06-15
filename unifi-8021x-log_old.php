<?php
/**
 * PHP API usage example
 *
 * contributed by: Art of WiFi
 * description:    example to pull connected user numbers for Access Points from the UniFi controller and output the results
 *                 in raw HTML format
 */

require_once 'vendor/autoload.php';
require_once 'config.php';

$site_id = 'wzyikf1b';

$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
//$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login();
$clients_array      = $unifi_connection->list_clients();

foreach ($clients_array as $c) {
    if($c->is_wired == false){
        echo ' assoc='.date("M j H:i:s", $c->assoc_time). ' latest_assoc='.date("M j H:i:s", $c->latest_assoc_time) . ' mac='.$c->mac. ' ap_mac='.$c->ap_mac.' IP='.$c->ip. ' essid='.$c->essid. ' 8021x='.$c->{'1x_identity'} ?: NULL. ' hostname='.$c->hostname ?: NULL;
        echo "\n";
    }
}


