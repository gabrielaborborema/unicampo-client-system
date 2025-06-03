<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
  public static function notNull(string $value, string $exceptMessage = null)
  {
    if (empty($value)) {
      throw new EntityValidationException($exceptMessage ?? 'Value should not be empty or null');
    }
  }

  public static function strMaxLength(string $value, int $maxLength = 255, string $exceptMessage = null)
  {
    if (strlen($value) > $maxLength) {
      throw new EntityValidationException($exceptMessage ?? "The value should not be longer than {$maxLength} characters");
    }
  }

  public static function strCanNullAndMaxLength(string $value = '', int $maxLength = 255, string $exceptMessage = null)
  {
    if (!empty($value) && strlen($value) > $maxLength) {
      throw new EntityValidationException($exceptMessage ?? "The value should not be longer than {$maxLength} characters when not null");
    }
  }
}
