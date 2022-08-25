<?php

namespace App\Menu;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Builder {

    private $factory;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private EntityManagerInterface $entityManager;
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        FactoryInterface $factory,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    ) {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function mainMenu(RequestStack $requestStack): ItemInterface {
        $menu = $this->factory->createItem('root');
        $token = $this->tokenStorage->getToken();
        /**@var User $user */
        $user = $token == null ? null : $this->tokenStorage->getToken()->getUser();

        $menu->addChild('Home', ['route' => 'app_home']);
        if(!is_null($user) && in_array("ROLE_ADMIN", $user->getRoles())) {
            $menu->addChild('Bookings', ['route' => 'app_booking_index']);
            $menu->addChild('Properties', ['route' => 'app_property_index']);
            $menu->addChild('Rate Plans', ['route' => 'app_rate_plan_index']);
            $menu->addChild('Property Types', ['route' => 'app_property_type_index']);
            $menu->addChild('Contact Us List', ['route' => 'app_message_index']);
            $menu->addChild('Logout', ['route' => 'logout']);
        } else if(!is_null($user) && in_array("ROLE_HOST", $user->getRoles())) {
            $menu->addChild('Bookings', ['route' => 'app_booking_index']);
            $menu->addChild('Properties', ['route' => 'app_property_index']);
            $menu->addChild('Rate Plans', ['route' => 'app_rate_plan_index']);
            $menu->addChild('Property Types', ['route' => 'app_property_type_index']);
            $menu->addChild('Contact Us', ['route' => 'app_message_new']);
            $menu->addChild('Logout', ['route' => 'logout']);
        } else if (!is_null($user) && in_array("ROLE_GUEST", $user->getRoles())){
            $menu->addChild('Bookings', ['route' => 'app_booking_index']);
            $menu->addChild('Contact Us', ['route' => 'app_message_new']);
            $menu->addChild('Logout', ['route' => 'logout']);
        } else {
            $menu->addChild('Login', ['route' => 'login']);
            $menu->addChild('Sign Up', ['route' => 'app_register']);
            $menu->addChild('Contact Us', ['route' => 'app_message_new']);
        }

//        $menu->addChild('Hotels', ['route' => 'app_hotel_index']);

//        /** @var Hotel[] $hotels */
//        $hotels = $this->entityManager->getRepository(Hotel::class)->findAll();
//
//        foreach ($hotels as $hotel) {
//            $menu['Hotels']->addChild($hotel->getName(), [
//                'route'           => 'app_hotel_show',
//                'routeParameters' => ['id' => $hotel->getId()],
//            ]);
//        }

        return $menu;
    }
}