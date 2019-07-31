<?php

use App\Entity\Client;
use App\Entity\ShippingAddress;
use App\Service\ShippingAddressService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShippingAddressServiceTest extends WebTestCase
{

    /**
     * Test create new shipping address
     */
    public function testCreateShippingAddress()
    {
        self::bootKernel();

        $shippingAddressEntity = self::$container->get('App\Service\ShippingAddressService')->createShippingAddress(
            'Latvia', 'Riga', 'Street', '1112222', 1
        );

        $this->assertInstanceOf(ShippingAddress::class, $shippingAddressEntity);
    }

    /**
     * Test update new shipping address
     */
    public function testUpdateShippingAddress()
    {
        self::bootKernel();

        /**
         * @var ShippingAddress $shippingAddressEntity
         */
        $shippingAddressEntity = self::$container->get('doctrine')->getRepository(ShippingAddress::class)
            ->findOneBy(['client_id' => 1, 'is_default' => 0]);

        $new_country = 'Latvia' . time();

        $shippingAddressEntity = self::$container->get('App\Service\ShippingAddressService')->updateShippingAddress(
            $shippingAddressEntity,
            $new_country,
            $shippingAddressEntity->getCity(),
            $shippingAddressEntity->getStreet(),
            $shippingAddressEntity->getZip(),
            $shippingAddressEntity->isIsDefault()
        );

        $this->assertTrue($shippingAddressEntity->getCountry() == $new_country);
    }

    /**
     * Test make default new shipping address
     */
    public function testMakeDefaultShippingAddress()
    {
        self::bootKernel();

        /**
         * @var ShippingAddress $shippingAddressEntity
         */
        $shippingAddressEntity = self::$container->get('doctrine')->getRepository(ShippingAddress::class)
            ->findOneBy(['client_id' => 1, 'is_default' => 0]);

        $shippingAddressEntity = self::$container->get('App\Service\ShippingAddressService')->makeDefaultShippingAddress(
            $shippingAddressEntity
        );

        $this->assertTrue($shippingAddressEntity->isIsDefault());
    }

    /**
     * Test delete new shipping address
     */
    public function testDeleteShippingAddress()
    {
        self::bootKernel();

        /**
         * @var ShippingAddress $shippingAddressEntity
         */
        $shippingAddressEntity = self::$container->get('doctrine')->getRepository(ShippingAddress::class)
            ->findOneBy(['client_id' => 1, 'is_default' => 0]);

        $result = self::$container->get('App\Service\ShippingAddressService')->deleteShippingAddress(
            $shippingAddressEntity
        );

        $this->assertTrue($result);
    }




/*// returns the real and unchanged service container
$container = self::$kernel->getContainer();

    // gets the special container that allows fetching private services
$container = self::$container;

$user = self::$container->get('doctrine')->getRepository(ShippingAddress::class)->findOneBy(['id' => 1]);*/
}