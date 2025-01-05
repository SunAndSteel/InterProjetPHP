// Fichier de configuration qui renvoie les informations de connexion au serveur LDAP

<?php
return [
    'ldap_server' => 'ldap://cd.hopital.com',
    'ldap_port' => 389,
    'base_dn' => 'dc=hospital, dc=lan',
    'admin_dn' => 'cn=admin,dc=users,dc=lan',
    'admin_password' => 'password',
];