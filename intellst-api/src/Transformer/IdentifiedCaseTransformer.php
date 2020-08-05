<?php

namespace App\Transformer;

use App\DTO\AllowEntranceDTO;
use App\DTO\IdentifiedCaseDTO;
use App\DTO\IdentifiedCaseTemperatureDTO;
use App\DTO\IdentifiedCaseUuidDTO;
use App\Entity\Enterprise;
use App\Entity\IdentifiedCase;
use Doctrine\ORM\EntityManagerInterface;

class IdentifiedCaseTransformer
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function transformDTOToEntity(IdentifiedCaseDTO $dto): IdentifiedCase
    {
        $identifiedCase = new IdentifiedCase();
        $identifiedCase->setPhotoFilename($dto->photoFilename);
        $identifiedCase->setUuid($dto->uuid);
        $identifiedCase->setTemperature($dto->temperature);
        $identifiedCase->setDatePhoto(new \DateTime());
        $identifiedCase->setFirstDate(new \DateTime());
        $enterprise = $this->em->getRepository(Enterprise::class)->find($dto->enterprise);
        $identifiedCase->setEnterprise($enterprise);
        return $identifiedCase;
    }

    public function transformEntityToDTO(IdentifiedCase $identifiedCase): IdentifiedCaseDTO
    {
        $identifiedCaseDTO = new IdentifiedCaseDTO();
        $identifiedCaseDTO->id = $identifiedCase->getId();
        $identifiedCaseDTO->photoFilename = $identifiedCase->getPhotoFilename();
        $identifiedCaseDTO->uuid = $identifiedCase->getUuid();
        $identifiedCaseDTO->temperature = $identifiedCase->getTemperature();
        $identifiedCaseDTO->datePhoto = $identifiedCase->getDatePhoto();
        $identifiedCaseDTO->firstDate = $identifiedCase->getFirstDate();
        $identifiedCaseDTO->enterprise = $identifiedCase->getEnterprise()->getName();

        return $identifiedCaseDTO;
    }

    public function transformDTOToEntityAllowEntrance(AllowEntranceDTO $dto, IdentifiedCase $identifiedCase): IdentifiedCase
    {
        $identifiedCase->setAllowEntrance(new \DateTime());

        return $identifiedCase;
    }

    public function transformEntityToDTOReturnAttempt(IdentifiedCase $identifiedCase): IdentifiedCaseTemperatureDTO
    {
        $identifiedCaseTemperatureDTO = new IdentifiedCaseTemperatureDTO();
        $identifiedCaseTemperatureDTO->temperature = $identifiedCase->getTemperature();

        return $identifiedCaseTemperatureDTO;
    }
}
