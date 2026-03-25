<?php

//J'ai adapté la réponse de l'IA à ce que nous avons vu en cours
class PostManager extends AbstractManager {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findOne(int $id): ?Post {
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = :id');
        $query->execute([':id' => $id]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Post(
            title:   $row['title'],
            excerpt: $row['excerpt'],
            content: $row['content'],
            id:      $row['id']
        );
    }
    
    public function findAll(): array {
        $query = $this->pdo->query('SELECT * FROM posts');
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
    
    
        //retourne un array contenant tous les posts
        return array_map(fn($row) => new Post(
            title:   $row['title'],
            excerpt: $row['excerpt'],
            content: $row['content'],
            id:      $row['id']
        ), $rows);
    }
    
    public function create(Post $post): void {
        $query = $this->pdo->prepare('
            INSERT INTO posts (title, excerpt, content)
            VALUES (:title, :excerpt, :content)
        ');

        $query->execute([
            ':title'   => $post->getTitle(),
            ':excerpt' => $post->getExcerpt(),
            ':content' => $post->getContent(),
        ]);
        
         $id = $this->pdo->lastInsertId();
         $post->setId($id);
    }
    
    public function update(Post $post): void {
        $query = $this->pdo->prepare('
            UPDATE posts
            SET title   = :title,
                excerpt = :excerpt,
                content = :content
            WHERE id = :id
        ');

        //Passe les paramètres directement au lieu de faire : 
        //$parameters = [
        //parametres ]
        //$query -> execute($parameters)
        $query->execute([
            ':title'   => $post->getTitle(),
            ':excerpt' => $post->getExcerpt(),
            ':content' => $post->getContent(),
            ':id'      => $post->getId(),
        ]);
    }
    
    public function delete(int $id): void {
        $query = $this->pdo->prepare('DELETE FROM posts WHERE id = :id');
        $query->execute([':id' => $id]);
    }
}