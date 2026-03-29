<?php

use Couchbase\UserManager;

class UserController extends AbstractController {

    public function login(): void
    {

        // Si l'utilisateur est déjà connecté, on le redirige
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        // Récupération et nettoyage des données du formulaire
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        // Validation des champs
        if (empty($email) || empty($password)) {
            http_response_code(400);
            throw new \Exception("L'email et le mot de passe sont obligatoires.");
        }

        // Recherche de l'utilisateur en base par email
        $um = new UserManager();
        $user = $um->findByEmail($email);

        // Si aucun utilisateur ne correspond à cet email
        if ($user === null) {
            http_response_code(404);
            throw new \Exception("Aucun compte ne correspond à cet email.");
        }

        // Vérification du mot de passe
        if (!$user->verifyPassword($password)) {
            http_response_code(403);
            throw new \Exception("Le mot de passe est incorrect.");
        }

        // Stockage de l'utilisateur en session
        $_SESSION['user'] = $user;

        // Redirection après connexion réussie
        header('Location: /');
        exit;
    }

    public function logout(): void {

        // Suppression de l'utilisateur en session
        unset($_SESSION['user']);

        // Destruction complète de la session
        session_destroy();

        // Redirection vers la page de connexion
        header('Location: /login');
        exit;
    }


