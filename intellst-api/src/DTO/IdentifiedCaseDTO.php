<?php

namespace App\DTO;

use DateTime;
use JMS\Serializer\Annotation as Serializer;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

class IdentifiedCaseDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Expose()
     * @Serializer\SerializedName("ID")
     */
    public int $id;

    /**
     * @Serializer\Expose()
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     * @Assert\NotBlank
     */
    public string $photoFilename;

    /**
     * @Serializer\Expose()
     * @Serializer\SerializedName("uuid")
     * @Serializer\Type("string")
     * @Assert\NotBlank
     */
    public string $uuid;

    /**
     * @Serializer\Expose()
     * @Serializer\SerializedName("temperature")
     * @Serializer\Type("float")
     * @Assert\NotBlank
     */
    public float $temperature;

    /**
     * @Serializer\Type("DateTime")
     * @Serializer\Expose()
     * @Serializer\SerializedName("datePhoto")
     */
    public DateTime $datePhoto;

    /**
     * @Serializer\Type("DateTime")
     * @Serializer\Expose()
     * @Serializer\SerializedName("firstDate")
     */
    public DateTime $firstDate;

//    /**
//     * @Serializer\Expose()
//     * @Serializer\SerializedName("enterprise")
//     * @Serializer\Type("integer")
//     * @Assert\NotBlank
//     */
//    public int $enterprise;

    /**
     * Enterprise IdentifiedCase
     * @var integer
     * @Assert\NotNull
     * @Serializer\Type("integer")
     * @Serializer\Expose()
     * @Serializer\SerializedName("enterprise")
     */
    public $enterprise;

}
