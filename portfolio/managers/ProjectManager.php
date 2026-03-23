<?php
class ProjectManager extends AbstractManager {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM projects');
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(fn($row) => new Project(
            title:       $row['title'],
            description: $row['description'],
            id:          $row['id']
        ), $rows);
    }
    
    public function findOne(int $id): ?Project {
        $stmt = $this->pdo->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Project(
            title:       $row['title'],
            description: $row['description'],
            id:          $row['id']
        );
    }
    
    public function create(Project $project): void {
        $stmt = $this->pdo->prepare('
            INSERT INTO projects (title, description)
            VALUES (:title, :description)
        ');

        $stmt->execute([
            ':title'       => $project->getTitle(),
            ':description' => $project->getDescription(),
        ]);
    }
    
    public function update(Project $project): void {
        $stmt = $this->pdo->prepare('
            UPDATE projects
            SET title       = :title,
                description = :description
            WHERE id = :id
        ');

        $stmt->execute([
            ':title'       => $project->getTitle(),
            ':description' => $project->getDescription(),
            ':id'          => $project->getId(),
        ]);
    }
    
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}