<?php

namespace App\Controller;

use App\Entity\ShippingAddress;
use App\Service\ShippingAddressService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ApiShippingAddressController
 * @package App\Controller
 */
final class ApiShippingAddressController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var ShippingAddressService */
    private $shippingAddressService;

    /**
     * ApiShippingAddressController constructor.
     * @param SerializerInterface $serializer
     * @param ShippingAddressService $shippingAddressService
     */
    public function __construct(SerializerInterface $serializer, ShippingAddressService $shippingAddressService)
    {
        $this->serializer = $serializer;
        $this->shippingAddressService = $shippingAddressService;
    }

    /**
     * @Rest\Post("/api/shipping_addresses/create", name="createShippingAddress")
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request): JsonResponse
    {
        $country = $request->request->get('country');
        $city    = $request->request->get('city');
        $street  = $request->request->get('street');
        $zip     = $request->request->get('zip');
        $is_default     = $request->request->get('is_default');

        $shippingAddressEntity = $this->shippingAddressService->createShippingAddress(
            $country,
            $city,
            $street,
            $zip,
            $is_default
        );

        $data = $this->serializer->serialize($shippingAddressEntity, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Post("/api/shipping_addresses/{id}/update", name="updateShippingAddress")
     * @param ShippingAddress $address
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAction(ShippingAddress $address, Request $request): JsonResponse
    {
        $country = $request->request->get('country');
        $city    = $request->request->get('city');
        $street  = $request->request->get('street');
        $zip     = $request->request->get('zip');
        $is_default = $request->request->get('is_default');

        $shippingAddressEntity = $this->shippingAddressService->updateShippingAddress(
            $address,
            $country,
            $city,
            $street,
            $zip,
            $is_default
        );

        $data = $this->serializer->serialize($shippingAddressEntity, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Post("/api/shipping_addresses/{id}/make_default", name="makeDefaultShippingAddress")
     * @param ShippingAddress $address
     * @return JsonResponse
     */
    public function makeDefault(ShippingAddress $address) {

        $shippingAddressEntity = $this->shippingAddressService->makeDefaultShippingAddress($address);

        $data = $this->serializer->serialize($shippingAddressEntity, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Post("/api/shipping_addresses/{id}/delete", name="deleteShippingAddress")
     * @param ShippingAddress $address
     * @return JsonResponse
     */
    public function delete(ShippingAddress $address) {

        $this->shippingAddressService->deleteShippingAddress($address);

        return new JsonResponse([], 200, [], true);

    }

    /**
     * @Rest\Get("/api/shipping_addresses", name="getAllShippingAddresses")
     * @return JsonResponse
     */
    public function getAllActions(): JsonResponse
    {
        $shippingAddressEntities = $this->shippingAddressService->getAll();
        $data = $this->serializer->serialize($shippingAddressEntities, 'json');

        return new JsonResponse($data, 200, [], true);
    }
}
