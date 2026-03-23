<?php
class PostManager extends AbstractManager {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findOne(int $id): ?Post {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

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
        $stmt = $this->pdo->query('SELECT * FROM posts');
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
    
        //retourne un array contenant tous les posts
        return array_map(fn($row) => new Post(
            title:   $row['title'],
            excerpt: $row['excerpt'],
            content: $row['content'],
            id:      $row['id']
        ), $rows);
    }
    
    public function create(Post $post): void {
        $stmt = $this->pdo->prepare('
            INSERT INTO posts (title, excerpt, content)
            VALUES (:title, :excerpt, :content)
        ');

        $stmt->execute([
            ':title'   => $post->getTitle(),
            ':excerpt' => $post->getExcerpt(),
            ':content' => $post->getContent(),
        ]);
    }
    
    public function update(Post $post): void {
        $stmt = $this->pdo->prepare('
            UPDATE posts
            SET title   = :title,
                excerpt = :excerpt,
                content = :content
            WHERE id = :id
        ');

        $stmt->execute([
            ':title'   => $post->getTitle(),
            ':excerpt' => $post->getExcerpt(),
            ':content' => $post->getContent(),
            ':id'      => $post->getId(),
        ]);
    }
    
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}