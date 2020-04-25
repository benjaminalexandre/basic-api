<?php declare(strict_types=1);

namespace App\Application\Provider\Validator;

use App\Application\Common\DtoInterface;
use App\Core\Utils\Translator;
use App\Domain\Exception\DomainException;
use App\Domain\Model\AbstractModel;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DomainConstraintValidator
 * @package App\Application\Provider\Validator
 */
class DomainConstraintValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * DomainConstraintValidator constructor.
     * @param ValidatorInterface $validator
     * @param Translator $translator
     */
    public function __construct(ValidatorInterface $validator, Translator $translator)
    {
        $this->validator = $validator;
        $this->translator = $translator;
    }

    /**
     * @param AbstractModel $entity
     * @param string|array $group
     * @param bool|null $checkLastUpdate
     * @param DtoInterface|null $dto
     */
    public function validate(
        AbstractModel $entity,
        $group,
        ?bool $checkLastUpdate = false,
        ?DtoInterface $dto = null
    ): void
    {
        /** @var ConstraintViolationListInterface $constraintViolationList */
        $constraintViolationList = $this->validator->validate($entity, null, $group);

        if($checkLastUpdate) {
            $this->checkLastUpdate($constraintViolationList, $entity, $dto);
        }

        if ($constraintViolationList->count()) {
            $message = "";
            foreach ($constraintViolationList as $constraintViolation) {
                $constraintMessage = $this->translator->trans($constraintViolation->getMessageTemplate(), $constraintViolation->getParameters(), Translator::DOMAIN_VALIDATORS);
                if($position = strpos($constraintMessage, '|')){
                    if($constraintViolation->getParameters()["{{ limit }}"] > 1){
                        $constraintMessage = substr($constraintMessage, $position+1);
                    } else {
                        $constraintMessage = substr($constraintMessage, 0, $position);
                    }
                }
                $message .= "{$constraintViolation->getPropertyPath()} : {$constraintMessage}" .
                    PHP_EOL;
            }

            $message = trim($message);
            throw new DomainException($message);
        }
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @param AbstractModel $entity
     * @param DtoInterface|null $dto
     */
    private function checkLastUpdate(
        ConstraintViolationListInterface &$constraintViolationList,
        AbstractModel $entity,
        ?DtoInterface $dto = null
    ): void
    {
        $propertyPath = "updatedAt";
        $getter = "get$propertyPath";
        $updatedAtEntity = $entity->$getter();
        $updatedAtCommand = $dto->$getter();

        if($updatedAtCommand != $updatedAtEntity) {
            $constraintViolationList->add(new ConstraintViolation(
                $message = $this->translator->trans("object_modified", [], Translator::DOMAIN_VALIDATORS),
                $message,
                [],
                $entity,
                $propertyPath,
                isset($updatedAtCommand) ? $updatedAtCommand : null
            ));
        }
    }
}