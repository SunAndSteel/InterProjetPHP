<?php
// Il faut mettre ici la connexion pour l'AD
$ldap_host = "ldap://ton-serveur-ad.local";
$ldap_user = "CN=admin,OU=Users,DC=ton-domaine,DC=local";
$ldap_password = "mot_de_passe";
$ldap_dn = "OU=Users,DC=ton-domaine,DC=local";

require 'db.php';

try {
    // Connexion LDAP 
    $ldap_conn = ldap_connect($ldap_host);
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    if (@ldap_bind($ldap_conn, $ldap_user, $ldap_password)) {
        echo "Connexion LDAP réussie.<br>";

        $filter = "(objectClass=user)";
        $attributes = ["cn", "mail", "sAMAccountName"];
        $search = ldap_search($ldap_conn, $ldap_dn, $filter, $attributes);

        if ($search) {
            $entries = ldap_get_entries($ldap_conn, $search);

            foreach ($entries as $entry) {
                if (isset($entry["samaccountname"][0])) {
                    $username = $entry["samaccountname"][0];
                    $email = $entry["mail"][0] ?? null;
                    $full_name = $entry["cn"][0];

                    $stmt = $pdo->prepare("
                        INSERT INTO users (username, email, full_name)
                        VALUES (:username, :email, :full_name)
                        ON DUPLICATE KEY UPDATE email=:email, full_name=:full_name
                    ");
                    $stmt->execute([
                        ':username' => $username,
                        ':email' => $email,
                        ':full_name' => $full_name
                    ]);
                    echo "Utilisateur synchronisé : $username<br>";
                }
            }
        } else {
            echo "Échec de la recherche LDAP.<br>";
        }
    } else {
        echo "Échec de la connexion LDAP.<br>";
    }
    ldap_close($ldap_conn);
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}
?>
