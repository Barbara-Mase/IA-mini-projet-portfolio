<?php

class PostController extends AbstractController {

    public function details(): void {
        $pm = new PostManager();

        // Récupération et validation de l'id depuis l'URL
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Si l'id est manquant ou non entier
        if (!$id) {
            http_response_code(400);
            throw new \Exception("L'identifiant du post est invalide.");
        }

        // Récupération du post en base
        $post = $pm->findOne($id);

        // Si aucun post ne correspond à cet id
        if ($post === null) {
            http_response_code(404);
            throw new \Exception("Ce post n'existe pas.");
        }

        // Affichage du détail du post
        $this->render('post/details', ['post' => $post]);
    }
    
    public function listPost() : void {
        
        $pm = new PostManager();
        
        $posts = $pm->findAll();
        
        
        //chemin à préciser
        $this->render("posts", ["posts" => $posts]);
        
        
    }
    
    public function create(): void {
    // Si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            throw new \Exception("Vous devez être connecté pour créer un post.");
        }
    
        // Récupération et nettoyage des données du formulaire
            $title   = htmlspecialchars(trim($_POST['title']));
            $content = htmlspecialchars(trim($_POST['content']));
            $excerpt = htmlspecialchars(trim($_POST['excerpt']));
    
        // Validation des champs
            if (empty($title) || empty($content) || empty($excerpt)) {
                http_response_code(400);
                throw new \Exception("Tous les champs sont obligatoires.");
            }
    
        // Création du post
            $pm   = new PostManager();
            $post = new Post($title, $excerpt, $content);
            $pm->create($post);
    
            // Redirection après succès
            header('Location: /posts');
            exit;
}
    

    public function update(): void {
        // Si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            throw new \Exception("Vous devez être connecté pour modifier un post.");
        }

        // Récupération et validation de l'id depuis l'URL
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            throw new \Exception("L'identifiant du post est invalide.");
        }

        // Vérification que le post existe
        $pm   = new PostManager();
        $post = $pm->findOne($id);

        if ($post === null) {
            http_response_code(404);
            throw new \Exception("Ce post n'existe pas.");
        }

        // Récupération et nettoyage des données du formulaire
        $title   = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));
        $excerpt = htmlspecialchars(trim($_POST['excerpt']));

        if (empty($title) || empty($content) || empty($excerpt)) {
            http_response_code(400);
            throw new \Exception("Tous les champs sont obligatoires.");
        }

        // Mise à jour du post
        $post = new Post($title, $excerpt, $content, $id);
        $pm->update($post);

        // Redirection après succès
        //Vérifier la redirection
        header('Location: /posts');
        exit;
        
        
    }
    
}