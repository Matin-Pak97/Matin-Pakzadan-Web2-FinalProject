<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Property;
use App\Entity\RatePlan;
use App\Entity\User;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\RatePlanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Date;

#[Route('/booking')]
class BookingController extends AbstractController
{
    private TokenStorageInterface $tokenStorage;
    private EntityManagerInterface $entityManager;
    private BookingRepository $bookingRepository;
    private RatePlanRepository $ratePlanRepository;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager,
        BookingRepository $bookingRepository,
        RatePlanRepository $ratePlanRepository
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
        $this->bookingRepository = $bookingRepository;
        $this->ratePlanRepository = $ratePlanRepository;
    }

    #[Route('/', name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Property $property): Response
    {
        $errors = '';
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $booking = new Booking();
        $booking->setBookingStartDate(new \DateTimeImmutable());
        $booking->setBookingEndDate((new \DateTimeImmutable())->modify('+1 day'));
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $totalGuestPrice = 0;
            $totalBookingPrice = 0;
            /** @var RatePlan $selectedRatePlan */
            $selectedRatePlan = $this->ratePlanRepository->findOneBy(['id' => $request->request->get('rate-plan')]);
            if($booking->getNumberOfGuest() <= $property->getMaxCapacity()) {
                if($booking->getNumberOfGuest() > $property->getMaxCapacity()) {
                    $totalGuestPrice = $booking->getNumberOfGuest() - $property->getMinCapacity() * $selectedRatePlan->getExtraGuestPrice();
                }
                $totalBookingPrice = $selectedRatePlan->getPrice() * date_diff($booking->getBookingStartDate(), $booking->getBookingEndDate())->days + $totalGuestPrice;

                $booking->setExtraGuestTotalPrice($totalGuestPrice);
                $booking->setTotalBookingPrice($totalBookingPrice);
                $booking->setProperty($property);
                $booking->setRatePlan($selectedRatePlan);
                $booking->setBookedBy($user);
                $booking->setStatus('Pending');

                $this->entityManager->persist($booking);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
            }
            else {
                $errors = 'The number of guest is more than max capacity of this property.';
            }
        }

        return $this->renderForm('booking/new.html.twig', [
            'property' => $property,
            'booking' => $booking,
            'form' => $form,
            'errors' => $errors
        ]);
    }

    #[Route('/{id}', name: 'app_booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->add($booking, true);

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($booking, true);
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
