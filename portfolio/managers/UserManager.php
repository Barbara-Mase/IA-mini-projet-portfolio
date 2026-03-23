<?php

class User extends AbstractManager {
    
    public function __construct() {
        
        parent::__construct();
    }
    

    public function findById(int $id): ?User
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        
        $parameters = [
            'id' => $id
            ];
            
        $query->execute($parameters);
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new User(
            $result['username'],
            $result['email'],
            $result['password'],
            $result['id']
        );
    }

    public function findByEmail(string $email): ?User
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        
        $parameters = [
            "email" => $email
            ];
        
        $query->execute($parameters);
        
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new User(
            $result['username'],
            $result['email'],
            $result['password'],
            $result['id']
        );
    }

    public function update(User $user): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE users
            SET username = :username,
                email    = :email,
                password = :password
            WHERE id = :id
        ');
        
        $parameters = [
            ':username' => $user->getUsername(),
            ':email'    => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':id'       => $user->getId(),
            ];

        $stmt->execute($parameters);
    }
}
