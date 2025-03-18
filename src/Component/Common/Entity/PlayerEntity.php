<?php

namespace App\Component\Common\Entity;

use App\Component\Common\Repository\PlayerRepository;
use App\Service\Doctrine\Type\JsonBValue;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JsonSerializable;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity(repositoryClass: PlayerRepository::class)]
#[Table(name: '`players`')]
#[UniqueConstraint(name: "idx_players_nickname", columns: ["nickname"])]
#[HasLifecycleCallbacks]
class PlayerEntity implements JsonSerializable
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    public int $id;

    #[Column(type: Types::STRING, length: 255, unique: true, nullable: true)]
    public ?string $nickname = null;

    #[Column(type: Types::STRING, length: 64, nullable: false)]
    #[NotBlank]
    public string $grade;

    #[Column(type: Types::BIGINT, nullable: false)]
    #[NotBlank]
    public string $money = '0';

    #[Column(type: "jsonb", nullable: true, options: ["jsonb" => true])]
    public ?JsonBValue $skills = null;

    #[Column(type: Types::TEXT)]
    #[NotBlank]
    public string $token;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    public DateTimeImmutable $createdAt;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    public DateTimeImmutable $updatedAt;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'fingerprint' => $this->token,
            'nick' => $this->nickname,
            'grade' => $this->grade,
            'money' => $this->money,
            'skills' => $this->skills,
        ];
    }

    #[PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
