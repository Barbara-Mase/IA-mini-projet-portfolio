<?php 

Class User 
{
    public function __construct(
        private string $username,
        private string $email,
        private string $password,
        private ?int $id = null
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email invalide : $email");
        }
        $this->email = $email;
    }

    public function setPassword(string $plainPassword): void
    {
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);

    }

}