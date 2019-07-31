<?php

namespace App\Controller;

use App\Entity\User;
use Safe\Exceptions\JsonException;
use App\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use function Safe\json_encode;

final class IndexController extends AbstractController
{
    // TODO: remove this var
    /** @var ClientService */
    private $clientService;

    /**
     * IndexController constructor.
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|_(profiler|wdt)).*"}, name="index")
     * @return Response
     * @throws JsonException
     */
    public function indexAction(): Response
    {
        /** @var User $user */
        //$user = $this->getUser();

        $user = $this->clientService->getTestUser();

        return $this->render('base.html.twig', [
            'isAuthenticated' => json_encode(!empty($user)),
            'firstName' => !empty($user) ? $user->getFirstName() : '',
            'lastName' => !empty($user) ? $user->getLastName() : '',
        ]);
    }
}
