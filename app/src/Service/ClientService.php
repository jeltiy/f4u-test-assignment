<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\ShippingAddress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\OutOfBoundsException;

final class ClientService
{

    /** @var EntityManagerInterface */
    private $em;

    /**
     * ShippingAddressService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Client $user
     * @param string $first_name
     * @param string $last_name
     * @throws InvalidArgumentException
     * @return Client
     */
    public function updateProfile(Client $user, string $first_name, string $last_name): Client
    {
        // fake test user
        $user = $this->getTestUser();

        $user->setFirstName($first_name);
        $user->setLastName($last_name);

        $this->em->flush();

        return $user;
    }

    /**
     * @return object
     */
    public function getTestUser()
    {
        return $this->em->getRepository(Client::class)->findOneBy(['id'=>1]);
    }

}
