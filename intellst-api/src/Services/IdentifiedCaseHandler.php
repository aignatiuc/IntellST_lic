<?php

namespace App\Services;

use App\DTO\AllowEntranceDTO;
use App\DTO\EnterpriseDTO;
use App\DTO\IdentifiedCaseDTO;
use App\DTO\UserDTO;
use App\Entity\Enterprise;
use App\Entity\IdentifiedCase;
use App\Entity\User;
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

    /** @var UserHandler */
    private $userHandler;

    /** @var EnterpriseTransformer */
    private $enterpriseTransformer;

    /**@var IdentifiedCaseRepository */
    private $identifiedCaseRepository;

    /**@var EnterpriseRepository */
    private $enterpriseRepository;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        IdentifiedCaseTransformer $identifiedCaseTransformer,
        IdentifiedCaseRepository $identifiedCaseRepository,
        EnterpriseTransformer $enterpriseTransformer,
        UserHandler $userHandler
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->identifiedCaseTransformer = $identifiedCaseTransformer;
        $this->identifiedCaseRepository = $identifiedCaseRepository;
        $this->identifiedCaseRepository = $this->em->getRepository(IdentifiedCase::class);
        $this->enterpriseRepository = $this->em->getRepository(Enterprise::class);
        $this->enterpriseTransformer = $enterpriseTransformer;
        $this->userHandler = $userHandler;
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

    public function updateIdentifiedCaseAllowEntrance(IdentifiedCase $identifiedCase): ConstraintViolationListInterface
    {
        $identifiedCase = $this->identifiedCaseTransformer->transformDTOToEntityAllowEntrance($identifiedCase);

        $errors = $this->validator->validate($identifiedCase);

        if ($errors->count() === 0) {
            $this->em->persist($identifiedCase);
            $this->em->flush();
        }

        return $errors;
    }

    public function showIdentifiedCase(): array
    {
        $user = $this->userHandler->getList();
        $temperature = $this->returnEnterpriseUser($user)->temperature;
        $data = $this->returnEnterpriseUser($user)->restrictionPeriod;
        $users = $this->identifiedCaseRepository->showNewIdentifiedCase($data, $temperature);
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

    public function allowEntrance(IdentifiedCaseDTO $dto): bool
    {
        $uuid = $dto->uuid;
        $list = $this->identifiedCaseRepository->allowEntrance($uuid);
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

    private function returnEnterpriseUser(UserDTO $dto): EnterpriseDTO
    {
        $enterprise = $this->enterpriseRepository->find($dto->enterprise);
        $enterpriseDTO = $this->enterpriseTransformer->transformEntityToDTO($enterprise);

        return $enterpriseDTO;
    }

    public function showReturnAttempt(): array
    {
        $user = $this->userHandler->getList();
        $temperature = $this->returnEnterpriseUser($user)->temperature;
        $data = $this->returnEnterpriseUser($user)->restrictionPeriod;
        $users = $this->identifiedCaseRepository->showNewIdentifiedCase($data, $temperature);
        $arr = [];
        foreach ($users as $identifiedCase) {
            $identifiedCaseDTO = $this->identifiedCaseTransformer->transformEntityToDTO($identifiedCase);
            $returnAttempt = $this->identifiedCaseRepository->showReturnAttempt($identifiedCaseDTO->uuid, $identifiedCaseDTO->firstDate);
            if (!empty($returnAttempt)){
            foreach ($returnAttempt as $case) {
                $caseDTO = $this->identifiedCaseTransformer->transformEntityToDTO($case);
                $arr[] = $caseDTO;
            }
            }
        }
        return $arr;
    }
}
