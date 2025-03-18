<?php

namespace App\Component\Common\Entity;

use App\Component\Common\Repository\QuoteRepository;
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

#[Entity(repositoryClass: QuoteRepository::class)]
#[Table(name: '`quotes`')]
#[HasLifecycleCallbacks]
class QuoteEntity implements JsonSerializable
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    public int $id;

    #[Column(type: Types::TEXT)]
    #[NotBlank]
    public string $text;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    public \DateTimeImmutable $createdAt;

    public function jsonSerialize(): array
    {
        return ['id' => $this->id, 'text' => $this->text];
    }

    #[PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
