<?php

declare(strict_types=1);

namespace spec\Loevgaard\SyliusBarcodePlugin\Validator\Constraints;

use Loevgaard\SyliusBarcodePlugin\Validator\Constraints\Barcode;
use Loevgaard\SyliusBarcodePlugin\Validator\Constraints\BarcodeValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class BarcodeValidatorSpec extends ObjectBehavior
{
    public function let(ExecutionContextInterface $executionContext): void
    {
        $this->initialize($executionContext);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BarcodeValidator::class);
    }

    public function it_extends_constraint(): void
    {
        $this->beAnInstanceOf(Constraint::class);
    }

    public function it_validates(ExecutionContextInterface $executionContext): void
    {
        $executionContext->buildViolation(Argument::any())->shouldNotBeCalled();
        $this->validate('4006381333931', new Barcode());
    }

    public function it_invalidates(ExecutionContextInterface $executionContext, ConstraintViolationBuilderInterface $constraintViolationBuilder): void
    {
        $value = 'invalid';

        $constraintViolationBuilder->setParameter('{{ string }}', $value)->willReturn($constraintViolationBuilder)->shouldBeCalled();
        $constraintViolationBuilder->addViolation()->shouldBeCalled();

        $constraint = new Barcode();
        $executionContext->buildViolation($constraint->message)->willReturn($constraintViolationBuilder)->shouldBeCalled();
        $this->validate($value, $constraint);
    }
}
