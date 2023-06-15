<?php

/*
 CONFIGURAÇÕES API
*/
$controlleruser     = 'myuser'; // the user name for access to the UniFi Controller
$controllerpassword = 'mypass'; // the password for access to the UniFi Controller
$controllerurl      = 'https://myunifi.com:8443'; // full url to the UniFi Controller, eg. 'https://22.22.11.11:8443', for UniFi OS-based
                          // controllers a port suffix isn't required, no trailing slashes should be added
$controllerversion  = '6.5.55'; // the version of the Controller software, e.g. '4.6.6' (must be at least 4.0.0)

$debug = false;

/*
 CONFIGURAÇÕES LDAP
*/
define('LDAP_TREE','dc=example,dc=com');
define('LDAP_SEARCH_DN','ou=people,'.LDAP_TREE);
define('LDAP_SEARCH_FILTER','(objectclass=*)');
define('LDAP_USER','cn=my_user,'.LDAP_TREE);
define('LDAP_HOST','8.8.8.8');
define('LDAP_PASS','mypass');
define('LDAP_MAX_SIMULTANEOUS_USE', 3);


/*
 CONFIGURAÇÕES EMAIL
*/
define('EMAIL_SENT_FROM','no-reply@example.com');
define('EMAIL_SENT_FROM_DESC','No reply email');
define('EMAIL_CC',EMAIL_SENT_FROM);
define('EMAIL_TITLE','Authentication Alert');

?>
