<?php

namespace App\Services;

use App\DTO\AllowEntranceDTO;
use App\DTO\EnterpriseDTO;
use App\DTO\IdentifiedCaseDTO;
use App\Entity\Enterprise;
use App\Entity\IdentifiedCase;
use App\Repository\EnterpriseRepository;
use App\Repository\IdentifiedCaseRepository;
use App\Transformer\EnterpriseTransformer;
use App\Transformer\IdentifiedCaseTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IdentifiedCaseHandler
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /** @var IdentifiedCaseTransformer */
    private $identifiedCaseTransformer;

    /** @var EnterpriseTransformer */
    private $enterpriseTransformer;

    /**
     * @var IdentifiedCaseRepository
     */
    private $identifiedCaseRepository;

    /**
     * @var EnterpriseRepository
     */
    private $enterpriseRepository;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        IdentifiedCaseTransformer $identifiedCaseTransformer,
        IdentifiedCaseRepository $identifiedCaseRepository,
        EnterpriseTransformer $enterpriseTransformer
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->identifiedCaseTransformer = $identifiedCaseTransformer;
        $this->identifiedCaseRepository = $identifiedCaseRepository;
        $this->identifiedCaseRepository = $this->em->getRepository(IdentifiedCase::class);
        $this->enterpriseRepository = $this->em->getRepository(Enterprise::class);
        $this->enterpriseTransformer = $enterpriseTransformer;
    }

    public function updateIdentifiedCase(IdentifiedCaseDTO $dto): ConstraintViolationListInterface
    {
        $identifiedCase = $this->identifiedCaseTransformer->transformDTOToEntity($dto);

        $errors = $this->validator->validate($identifiedCase);
        $dtoErrors = $this->validator->validate($dto, null);

        foreach ($dtoErrors as $error) {
            $errors->add($error);
        }

        if ($errors->count() === 0) {
            $this->em->persist($identifiedCase);
            $this->em->flush();
        }

        return $errors;
    }

    public function getList(): array
    {
        $users = $this->identifiedCaseRepository->findAll();
        $arr = [];
        foreach ($users as $identifiedCase) {
            $identifiedCaseDTO = $this->identifiedCaseTransformer->transformEntityToDTO($identifiedCase);
            $arr[] = $identifiedCaseDTO;
        }

        return $arr;
    }

    public function updateIdentifiedCaseAllowEntrance(AllowEntranceDTO $dto, IdentifiedCase $identifiedCase): ConstraintViolationListInterface
    {
        $identifiedCase = $this->identifiedCaseTransformer->transformDTOToEntityAllowEntrance($dto,$identifiedCase);

        $errors = $this->validator->validate($identifiedCase);
        $dtoErrors = $this->validator->validate($dto, null);

        foreach ($dtoErrors as $error) {
            $errors->add($error);
        }

        if ($errors->count() === 0) {
            $this->em->persist($identifiedCase);
            $this->em->flush();
        }

        return $errors;
    }

    public function showIdentifiedCase(int $value): array
    {
        $users = $this->identifiedCaseRepository->showNewIdentifiedCase($value);
        $arr = [];
        foreach ($users as $identifiedCase) {
            $identifiedCaseDTO = $this->identifiedCaseTransformer->transformEntityToDTO($identifiedCase);
            $arr[] = $identifiedCaseDTO;
        }

        return $arr;
    }

    public function returnAttempt(IdentifiedCaseDTO $dto): bool
    {
        $temperature = $this->returnEnterprise($dto)->temperature;
        $day = $this->returnEnterprise($dto)->restrictionPeriod;
        $uuid = $dto->uuid;
        $list = $this->identifiedCaseRepository->returnAttempt($day, $temperature, $uuid);
        $arr = [];
        foreach ($list as $identifiedCase) {
            $identifiedCaseDTO = $this->identifiedCaseTransformer->transformEntityToDTO($identifiedCase);
            $arr[] = $identifiedCaseDTO;
        }
        if (!empty($arr)) {

            return true ;
        }
        else return false;
    }

    private function returnEnterprise(IdentifiedCaseDTO $dto): EnterpriseDTO
    {
        $enterprise = $this->enterpriseRepository->find($dto->enterprise);
        $enterpriseDTO = $this->enterpriseTransformer->transformEntityToDTO($enterprise);
        return $enterpriseDTO;
    }
}
