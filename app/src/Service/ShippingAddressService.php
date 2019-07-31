<?php

namespace App\Service;

use App\Entity\ShippingAddress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\OutOfBoundsException;

final class ShippingAddressService
{
    /**
     * Client maximum addresses
     */
    const CLIENT_MAX_ADDRESSES = 3;

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
     * @param string $country
     * @param string $city
     * @param string $street
     * @param string $zip
     * @param bool $is_default
     * @throws OutOfBoundsException
     * @return ShippingAddress
     */
    public function createShippingAddress(string $country, string $city,
                                          string $street, string $zip, bool $is_default): ShippingAddress
    {

        $clientShippingAddresses = $this->em->getRepository(ShippingAddress::class)
            ->findBy(['client_id' => 1]);

        if(count($clientShippingAddresses) >= self::CLIENT_MAX_ADDRESSES) {
            throw new OutOfBoundsException('You can only create three shipping addresses');
        }

        $shippingAddressEntity = new ShippingAddress();
        // TODO: change to the real client_id
        $shippingAddressEntity->setClientId(1);

        $shippingAddressEntity->setCountry($country);
        $shippingAddressEntity->setCity($city);
        $shippingAddressEntity->setStreet($street);
        $shippingAddressEntity->setZip($zip);

        $this->em->persist($shippingAddressEntity);

        // if this is the first client's address make it as default
        if($is_default || !count($clientShippingAddresses)) {
            $this->makeDefaultShippingAddress($shippingAddressEntity);
        } else {
            $this->em->flush();
        }

        return $shippingAddressEntity;
    }

    /**
     * @param ShippingAddress $shippingAddressEntity
     * @param string $country
     * @param string $city
     * @param string $street
     * @param string $zip
     * @param bool $is_default
     * @throws InvalidArgumentException
     * @return ShippingAddress
     */
    public function updateShippingAddress(ShippingAddress $shippingAddressEntity,
                                          string $country, string $city,
                                          string $street, string $zip, bool $is_default): ShippingAddress
    {
        if($shippingAddressEntity->isIsDefault() && !$is_default) {
            throw new InvalidArgumentException('Must have a default address');
        } else
        if($shippingAddressEntity->isIsDefault() != $is_default) {
            $this->makeDefaultShippingAddress($shippingAddressEntity);
        }

        $shippingAddressEntity->setCountry($country);
        $shippingAddressEntity->setCity($city);
        $shippingAddressEntity->setStreet($street);
        $shippingAddressEntity->setZip($zip);

        $this->em->flush();

        return $shippingAddressEntity;
    }

    /**
     * @param ShippingAddress $shippingAddressEntity
     * @return ShippingAddress
     */
    public function makeDefaultShippingAddress(ShippingAddress $shippingAddressEntity): ShippingAddress
    {
        // reset default address(es)
        $defaultShippingAddresses = $this->em->getRepository(ShippingAddress::class)
            ->findBy(['client_id' => 1, 'is_default' => 1]);

        foreach($defaultShippingAddresses as $address) {
            $address->setIsDefault(false);
        }

        $shippingAddressEntity->setIsDefault(true);

        $this->em->flush();

        return $shippingAddressEntity;
    }

    /**
     * @param ShippingAddress $shippingAddressEntity
     * @throws InvalidArgumentException
     * @return bool
     */
    public function deleteShippingAddress(ShippingAddress $shippingAddressEntity): bool
    {
        if($shippingAddressEntity) {

            if($shippingAddressEntity->isIsDefault()) {
                throw new InvalidArgumentException('You cannot delete your default address');
            } else {

                $this->em->remove($shippingAddressEntity);
                $this->em->flush();

                return true;
            }
        }

        return false;
    }

    /**
     * @return object[]
     */
    public function getAll(): array
    {
        return $this->em->getRepository(ShippingAddress::class)->findBy([], ['id' => 'DESC']);
    }
}
