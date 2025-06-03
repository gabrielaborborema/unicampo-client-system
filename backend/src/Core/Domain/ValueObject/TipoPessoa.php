<?php

namespace Core\Domain\ValueObject;

use InvalidArgumentException;

enum TipoPessoa: string
{
  case FISICA = 'física';
  case JURIDICA = 'jurídica';

  public static function fromString(string $valor): self
  {
    foreach (self::cases() as $case) {
      if (mb_strtolower($valor, 'UTF-8') === mb_strtolower($case->value, 'UTF-8')) {
        return $case;
      }
    }

    throw new InvalidArgumentException("Tipo de pessoa inválido: {$valor}");
  }

  public function getValor(): string
  {
    return $this->value;
  }

  public function equals(self $outro): bool
  {
    return $this === $outro;
  }
}
