<?php

namespace App\Controller;

use App\DTO\IdentifiedCaseDTO;
use App\DTO\IdentifiedCaseTemperatureDTO;
use App\Entity\IdentifiedCase;
use App\Repository\IdentifiedCaseRepository;
use App\Services\IdentifiedCaseHandler;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\ValidationErrorSerializer;

class IdentifiedCaseController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var IdentifiedCaseHandler
     */
    private $identifiedCaseHandler;

    /**
     * @var ValidationErrorSerializer
     */
    private $validationErrorSerializer;

    /**
     * @var IdentifiedCaseRepository
     */
    private $identifiedCaseRepository;

    public function __construct(
        IdentifiedCaseHandler $identifiedCaseHandler,
        SerializerInterface $serializer,
        ValidationErrorSerializer $validationErrorSerializer,
        IdentifiedCaseRepository $identifiedCaseRepository
    )
    {
        $this->serializer = $serializer;
        $this->identifiedCaseHandler = $identifiedCaseHandler;
        $this->validationErrorSerializer = $validationErrorSerializer;
        $this->identifiedCaseRepository = $identifiedCaseRepository;
    }

    /**
     * @Route("/api/identified-case", name="add_identified_case", methods={"POST"})
     */
    public function addIdentifiedCase(Request $request): JsonResponse
    {
        $data = $request->getContent();

        $addIdentifiedCaseDTO = $this->serializer->deserialize(
            $data,
            IdentifiedCaseDTO::class,
            'json'
        );

        $errors = $this->identifiedCaseHandler->updateIdentifiedCase($addIdentifiedCaseDTO);
        if ($errors->count()) {
            return new JsonResponse(
                [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Bad Request',
                    'errors' => $this->validationErrorSerializer->serialize($errors),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $returnAttempt = $this->identifiedCaseHandler->returnAttempt($addIdentifiedCaseDTO);

        if ($returnAttempt===true) {
            var_dump($returnAttempt);
            return new JsonResponse(
                [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' =>'This person does not have access',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

//        return new JsonResponse($returnAttempt);

        return new JsonResponse(['message' => 'Identified Case added successfully'], Response::HTTP_OK);
    }

    /**
     * @Route("/api/identified-case", name="show_list_identified_case", methods={"GET"})
     */
    public function listIdentifiedCase(): JsonResponse
    {
        $list = $this->identifiedCaseHandler->getList();

        return new JsonResponse($list);
    }

    /**
     * @Route("/api/identified-case/{identified-case}", name="edit_allow_entrance", methods={"POST"})
     */
    public function editAllowEntrance(Request $request, IdentifiedCase $identifiedCase): JsonResponse
    {
        $data = $request->getContent();

        $editAllowEntrance = $this->serializer->deserialize(
            $data,
            IdentifiedCaseDTO::class,
            'json'
        );

        $errors = $this->identifiedCaseHandler->updateIdentifiedCaseAllowEntrance($editAllowEntrance,$identifiedCase);
        if ($errors->count()) {
            return new JsonResponse(
                [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Bad Request',
                    'errors' => $this->validationErrorSerializer->serialize($errors),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(['message' => 'Entry allowed successfully'], Response::HTTP_OK);
    }
//
//    /**
//     * @Route("/api/show-identified-case/{day}", name="show_list_identified_case", methods={"GET"})
//     */
//    public function showNewIdentifiedCase(int $day): JsonResponse
//    {
//        $notification = $this->identifiedCaseHandler->showIdentifiedCase($day);
//
//        return new JsonResponse($notification);
//    }


    /**
     * @Route("/api/show-identified-case", name="show_list_return_attempt", methods={"POST"})
     */
    public function showReturnAttempt(Request $request): JsonResponse
    {
        $data = $request->getContent();

        $temperatureDTO = $this->serializer->deserialize(
            $data,
            IdentifiedCaseDTO::class,
            'json'
        );

        $returnAttempt = $this->identifiedCaseHandler->returnAttempt($temperatureDTO);

        return new JsonResponse($returnAttempt);

    }


//    /**
//     * @Route("/api/show-identified-case/{day}", name="show_list_return_attempt", methods={"POST"})
//     */
//    public function showReturnAttempt(Request $request, string $day): JsonResponse
//    {
//        $data = $request->getContent();
//
//        $uuidDTO = $this->serializer->deserialize(
//            $data,
//            IdentifiedCaseUuidDTO::class,
//            'json'
//        );
//
//        $returnAttempt = $this->identifiedCaseHandler->returnAttempt($day, $uuidDTO);
//
//        return new JsonResponse($returnAttempt);
//
//    }



}
