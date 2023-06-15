<?php

require_once 'vendor/autoload.php';
require_once 'config.php';
require_once "mail.php";

$site_id = 'wzyikf1b';

$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
//$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login();
$clients_array      = $unifi_connection->list_clients();

$clients_count = array();

foreach ($clients_array as $c) {
    if($c->is_wired == false){
        echo ' assoc='.date("M j H:i:s", $c->assoc_time). ' latest_assoc='.date("M j H:i:s", $c->latest_assoc_time) . ' mac='.$c->mac. ' ap_mac='.$c->ap_mac.' IP='.$c->ip. ' essid='.$c->essid. ' 8021x='.$c->{'1x_identity'} ?: NULL. ' hostname='.$c->hostname ?: NULL;
        echo "\n";
        if (isset($c->{'1x_identity'}) ){
            $ident = $c->{'1x_identity'};

            if(filter_var($ident, FILTER_VALIDATE_EMAIL)) {
                $ident = substr($ident, 0, strpos($ident, '@'));
                $clients_count[] = $ident;
            }
            else {
                $clients_count[] = $ident;
            }
        }
    }
}

foreach (array_count_values($clients_count) as $key=>$value) {
    if ($value > LDAP_MAX_SIMULTANEOUS_USE){
     //echo "\n";
     echo 'Sending e-mail to user '.$key.' that is authenticated in '.$value.' devices. It is not allowed to connect to more than '.LDAP_MAX_SIMULTANEOUS_USE.' devices';
     $mail = getUserEmailFromLDAP($key);

        if(isset($mail)){
            sendEmail($key,$value,$mail);
        }
    }
}

function getUserEmailFromLDAP($user) {

    $lcon = connectLDAP(LDAP_HOST);
    if ($lcon){
        $ldapbind = bindLDAP($lcon);
        if(isset($ldapbind)){
            $mail = searchUserLDAP($lcon,$user);
            ldap_close($lcon);
            return $mail;
        }
    }
    ldap_close($lcon);
    return null;
}

function connectLDAP($host){
    
    // connect to ldap server
    $ldapconn = ldap_connect("ldap://".$host)
        or die("Could not connect to LDAP server.");

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

    return $ldapconn;
}

function bindLDAP($con){
    
    $ldapbind = ldap_bind($con, LDAP_USER, LDAP_PASS);

    // verify binding
    if ($ldapbind) {
        echo " 1) LDAP bind successful ";
        return $ldapbind;
    } else {
        echo " 1) LDAP bind failed ";
        return null;
    }
}

function searchUserLDAP($con,$user){
    
    $filter="(|(uid=$user*)(cn=$user*)(mail=$user))";
    $justthese = array("mail");
    $sr=ldap_search($con, LDAP_SEARCH_DN, $filter, $justthese);
    $info = ldap_get_entries($con, $sr);

    if ($info["count"] > 0){
        $email = $info[0]['mail'][0];
        echo " 2) found email ".$email." ";
        return $email; 
    }
    else{
        echo " 2) could not find user email ";
        return null;
    }
}

function sendEmail($login,$vezes,$requesterEmail){

    try {
        $mailer = new MailSender();
        $mailer->setTemplateURL('message.html');
        $mailer->compose(array(
        "login" => $login,
        "vezes" => $vezes,
        "max" => LDAP_MAX_SIMULTANEOUS_USE
        ));

        $mailer->AddCC(EMAIL_CC);

        $sended = $mailer->send(array(EMAIL_SENT_FROM, EMAIL_SENT_FROM_DESC),$requesterEmail,EMAIL_TITLE); 

        echo ' 3) Message has been sent';
    } catch (Exception $e) {
        echo " 3) Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
        echo "\n";
}

?>
