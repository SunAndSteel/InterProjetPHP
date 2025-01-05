<?php
class user_model 
{
public function __construct() {
    require 'db.php';
}

    
    #CRUD
    public function create($data)
    {
        require 'db.php';

        $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        return $stmt->execute([
            ':username' => $data['username'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':email' => $data['email']
        ]);
    }

    public function update($id, $data)
    {
        require 'db.php';

        $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        return $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':id' => $id
        ]);
    }

    public function delete($id)
    {
        require 'db.php';

        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function findByName($username)
    {
        require 'db.php';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);

        return $stmt->fetch();
    }
    public function findAll()
    {
        require 'db.php';

        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>