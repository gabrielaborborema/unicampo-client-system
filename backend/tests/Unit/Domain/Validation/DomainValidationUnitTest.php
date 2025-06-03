<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationUnitTest extends TestCase
{
  public function testNotNull()
  {
    try {
      $value = '';
      DomainValidation::notNull($value);

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th);
    }
  }

  public function testNotNullCustomMessage()
  {
    try {
      $value = '';
      DomainValidation::notNull($value, 'custom except message');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th, 'custom except message');
    }
  }

  public function testStrMaxLength()
  {
    try {
      $value = 'abcdefg';
      DomainValidation::strMaxLength($value, 5);

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th);
    }
  }

  public function testStrCanNullAndMaxLength()
  {
    try {
      $value = 'testing';
      DomainValidation::strCanNullAndMaxLength($value, 5);

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(EntityValidationException::class, $th);
    }
  }
}
