<?php

namespace Core\Domain\ValueObject;

use InvalidArgumentException;

enum StatusCliente: string
{
  case ATIVO = 'ativo';
  case INATIVO = 'inativo';

  public static function fromString(string $valor): self
  {
    foreach (self::cases() as $case) {
      if (mb_strtolower($valor, 'UTF-8') === mb_strtolower($case->value, 'UTF-8')) {
        return $case;
      }
    }
    throw new InvalidArgumentException("Status de cliente inválido: {$valor}");
  }

  public function getValor(): string
  {
    return $this->value;
  }

  public function isActive(): bool
  {
    return $this === self::ATIVO;
  }
}
