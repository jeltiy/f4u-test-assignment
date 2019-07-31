<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Service\ClientService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ApiSecurityController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var ClientService */
    private $clientService;

    /**
     * ApiSecurityController constructor.
     * @param SerializerInterface $serializer
     * @param ClientService $clientService
     */
    public function __construct(SerializerInterface $serializer, ClientService $clientService)
    {
        $this->serializer = $serializer;
        $this->clientService = $clientService;
    }

    /**
     * @Route("/api/security/login", name="login")
     * @return JsonResponse
     */
    public function loginAction(): JsonResponse
    {
        /** @var User $user */
        //$user = $this->getUser();

    }

    /**
     * @Route("/api/security/updateProfile", name="updateProfile")
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAction(Request $request): JsonResponse
    {
        // Get current user
        $user = new Client();

        $firstName = $request->request->get('first_name');
        $lastName  = $request->request->get('last_name');

        $userEntity = $this->clientService->updateProfile(
            $user,
            $firstName,
            $lastName
        );

        $data = $this->serializer->serialize($userEntity, 'json');

        return new JsonResponse($data, 200, [], true);

    }
}
