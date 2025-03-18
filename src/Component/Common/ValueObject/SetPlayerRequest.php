<?php

declare(strict_types=1);

namespace App\Component\Common\ValueObject;

use Symfony\Component\Validator\Constraints\NotBlank;

class SetPlayerRequest
{
    public function __construct(
        #[NotBlank]
        public string $fingerprint,
        public ?string $nick = null,
        public string $grade = 'Junior',
        public int | string $money = 0,
        public array $skills = [],
    ) {
    }
}
