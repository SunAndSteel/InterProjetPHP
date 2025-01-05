<?php
class login_model  {
    private $ldapConnection;
    private $config;

    public function __construct($config) {
        $this->config = $config;
        $this->ldapConnection = ldap_connect($this->config['ldap_server'], $this->config['ldap_port']);
        ldap_set_option($this->ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldapConnection, LDAP_OPT_REFERRALS, 0);
    }

    /**
     * Attempts to log in to the LDAP server using the given username and password
     *
     * @param string $username 
     * @param string $password 
     *
     * @return bool True si le login est reussi, false sinon
     */
    public function ldapLogin($username, $password)
    {
        $user_dn = "cn=$username," . $this->config['base_dn'];
        return @ldap_bind($this->ldapConnection, $user_dn, $password);
    }

    public function ldapLogout()
    {
        return ldap_unbind($this->ldapConnection);
    }

}


