<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class IdentifiedCaseTemperatureDTO
{
    /**
     * @Serializer\Expose()
     * @Serializer\SerializedName("temperature")
     * @Serializer\Type("float")
     * @Assert\NotBlank
     */
    public float $temperature;
}
