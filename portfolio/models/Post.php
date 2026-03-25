<?php

class Post
{
    
    
    
    public function __construct(
        private string $title,
        private string $excerpt,
        private string $content,
        private ?int $id = null
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setTitle(string $title): void
    {
        if (trim($title) === '') {
            throw new \InvalidArgumentException('Le titre ne peut pas être vide.');
        }
        $this->title = $title;
    }

    private function setExcerpt(string $excerpt) : void {
        $this->excerpt = $excerpt;
    }
    
    public function setContent(string $content): void
    {
        $this->content = $content;
    }



}