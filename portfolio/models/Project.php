<?php


class Project
{
    public function __construct(
        private string $title,
        private string $description,
        private string $url,
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

    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getUrl(): string
    {
        return $this->url;
    }

    public function setTitle(string $title): void
    {
        if (trim($title) === '') {
            throw new \InvalidArgumentException('Le titre ne peut pas être vide.');
        }
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
    
    public function setUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("URL invalide : $url");
        }
        $this->url = $url;
    }




}