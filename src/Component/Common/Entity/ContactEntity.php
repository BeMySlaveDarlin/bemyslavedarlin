<?php

namespace App\Component\Common\Entity;

use App\Component\Common\Repository\ContactRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity(repositoryClass: ContactRepository::class)]
#[Index(columns: ['type'], name: 'idx_contacts_type')]
#[Table(name: '`contacts`')]
#[HasLifecycleCallbacks]
class ContactEntity implements JsonSerializable
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    public int $id;

    #[Column(type: Types::TEXT)]
    #[NotBlank]
    public string $contact;

    #[Column(type: Types::STRING, length: 100, nullable: true)]
    public ?string $type = null;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    public DateTimeImmutable $createdAt;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'contact' => $this->contact,
        ];
    }

    #[PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
