<?php

namespace App\Controller;

use App\DTO\IdentifiedCaseDTO;
use App\Entity\IdentifiedCase;
use App\Repository\IdentifiedCaseRepository;
use App\Services\IdentifiedCaseHandler;
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

    public function __construct(
        IdentifiedCaseHandler $identifiedCaseHandler,
        SerializerInterface $serializer,
        ValidationErrorSerializer $validationErrorSerializer
    ) {
        $this->serializer = $serializer;
        $this->identifiedCaseHandler = $identifiedCaseHandler;
        $this->validationErrorSerializer = $validationErrorSerializer;
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
        $allowEntrance = $this->identifiedCaseHandler->isEntranceAllowed($addIdentifiedCaseDTO);
        if ($allowEntrance === false) {
            return new JsonResponse(['message' => 'Allow Entrance'], Response::HTTP_OK);
        }
        $returnAttempt = $this->identifiedCaseHandler->isReturnAttempt($addIdentifiedCaseDTO);
        if ($returnAttempt === true) {
            return new JsonResponse(
                [
                    'code' => Response::HTTP_OK,
                    'message' => 'This person does not have access',
                ],
                Response::HTTP_OK
            );
        }

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
     * @Route("/api/allow-entrance/{uuid}", name="edit_identified_case", methods={"POST"})
     */
    public function editAllowEntrance(IdentifiedCase $identifiedCase): JsonResponse
    {
        $errors = $this->identifiedCaseHandler->updateIdentifiedCaseAllowEntrance($identifiedCase);
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

    /**
     * @Route("/api/show-identified-case", name="show_list_new_identified_case", methods={"GET"})
     */
    public function getNewIdentifiedCase(): JsonResponse
    {
        $notification = $this->identifiedCaseHandler->getIdentifiedCases();

        return new JsonResponse($notification);
    }

    /**
     * @Route("/api/show-return-attempt", name="show_list_return_attempt", methods={"GET"})
     */
    public function getReturnAttempts(): JsonResponse
    {
        $returnAttempt = $this->identifiedCaseHandler->getRecentReturnAttempts();

        return new JsonResponse($returnAttempt);
    }
}
