<?php

class ProjectController extends AbstractController {


    public function details(): void {

        $pm = new ProjectManager();

        // Récupération et validation de l'id depuis l'URL
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Si l'id est manquant ou non entier
        if (!$id) {
            http_response_code(400);
            throw new \Exception("L'identifiant du projet est invalide.");
        }

        // Récupération du post en base
        $project = $pm->findOne($id);

        // Si aucun post ne correspond à cet id
        if ($project === null) {
            http_response_code(404);
            throw new \Exception("Ce projet n'existe pas.");
        }

        // Affichage du détail du post
        $this->render('project/details', ['project' => $project]);
    }

    public function list(): void {
        // Instanciation du manager
        $pm = new ProjectManager();

        // Récupération de tous les projets en base
        $projects = $pm->findAll();

        // Affichage de la liste des projets
        $this->render('project/list', ['projects' => $projects]);

        //Potentiellement ajouter
    }

    public function create(): void {
        // Si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            throw new \Exception("Vous devez être connecté pour créer un projet.");
        }

        // Récupération et nettoyage des données du formulaire
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $url = htmlspecialchars(trim($_POST['url']));

        // Validation des champs
        if (empty($title) || empty($description) || empty($url)) {
            http_response_code(400);
            throw new \Exception("Tous les champs sont obligatoires.");
        }

        // Création du post
        $pm = new ProjectManager();
        $project = new Project($title, $description, $url);
        $pm->create($project);

        // Redirection après succès
        header('Location: /project/list');
        exit;
    }

    public function update(): void {
        // Si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            throw new \Exception("Vous devez être connecté pour modifier un projet.");
        }

        // Récupération et validation de l'id depuis l'URL
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            throw new \Exception("L'identifiant du projet est invalide.");
        }

        // Vérification que le post existe
        $pm   = new ProjectManager();
        $project = $pm->findOne($id);

        if ($project === null) {
            http_response_code(404);
            throw new \Exception("Ce projet n'existe pas.");
        }

        // Récupération et nettoyage des données du formulaire
        $title   = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['description']));
        $excerpt = htmlspecialchars(trim($_POST['url']));

        if (empty($title) || empty($description) || empty($url)) {
            http_response_code(400);
            throw new \Exception("Tous les champs sont obligatoires.");
        }

        // Mise à jour du post
        $project = new Project($title, $description, $url, $id);
        $pm->update($project);

        // Redirection après succès
        //Vérifier la redirection
        header('Location: /project/list');
        exit;


    }
    public function delete() : void {
        //Si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            throw new \Exception("Vous devez être connecté pour supprimer un projet.");
        }

        // Récupération et validation de l'id depuis l'URL
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            throw new \Exception("L'identifiant du projet est invalide.");
        }

        // Vérification que le projet existe
        $pm      = new ProjectManager();
        $project = $pm->findOne($id);

        if ($project === null) {
            http_response_code(404);
            throw new \Exception("Ce projet n'existe pas.");
        }

        // Suppression du projet
        $pm->delete($id);

        // Redirection après succès
        header('Location: /project/list');
        exit;
    }
}