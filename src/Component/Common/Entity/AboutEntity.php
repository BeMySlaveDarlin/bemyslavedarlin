<?php

namespace App\Component\Common\Entity;

use App\Component\Common\Repository\AboutRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity(repositoryClass: AboutRepository::class)]
#[Table(name: '`about`')]
#[HasLifecycleCallbacks]
class AboutEntity implements JsonSerializable
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    public int $id;

    #[Column(type: Types::TEXT)]
    #[NotBlank]
    public string $title;

    #[Column(type: Types::TEXT, nullable: true)]
    #[NotBlank]
    public ?string $description = null;

    #[Column(type: Types::STRING, nullable: true)]
    #[NotBlank]
    public string $type;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    public \DateTimeImmutable $createdAt;

    public function jsonSerialize(): array
    {
        return ['id' => $this->id, 'title' => $this->title, 'type' => $this->type, 'description' => $this->description];
    }

    #[PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
