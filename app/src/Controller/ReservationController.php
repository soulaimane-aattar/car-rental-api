<?php
namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Car;
use App\Entity\User;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends AbstractController
{
    private $reservationService;
    private $entityManager;

    public function __construct(ReservationService $reservationService, EntityManagerInterface $entityManager)
    {
        $this->reservationService = $reservationService;
        $this->entityManager = $entityManager;
    }

    public function createReservation(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $carId = $data['carId'];
        $startDate = new \DateTime($data['startDate']);
        $endDate = new \DateTime($data['endDate']);

        if (!$this->reservationService->isCarAvailable($carId, $startDate, $endDate)) {
            return $this->json(['error' => 'Car is not available'], Response::HTTP_CONFLICT);
        }

        $car = $this->entityManager->getRepository(Car::class)->find($carId);
        if (!$car) {
            return $this->json(['error' => 'Car not found'], Response::HTTP_NOT_FOUND);
        }

        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        $reservation = new Reservation();
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUser($user);
        $reservation->setCar($car);

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $this->json($reservation);
    }

    public function getUserReservations(int $id, ReservationRepository $reservationRepository): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $reservations = $reservationRepository->findBy(['user' => $user]);

        return $this->json($reservations);
    }

    public function updateReservation(int $id, Request $request): Response
    {
        $reservation = $this->entityManager->getRepository(Reservation::class)->find($id);
        if (!$reservation) {
            return $this->json(['error' => 'Reservation not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['startDate'])) {
            $reservation->setStartDate(new \DateTime($data['startDate']));
        }
        if (isset($data['endDate'])) {
            $reservation->setEndDate(new \DateTime($data['endDate']));
        }

        $this->entityManager->flush();

        return $this->json($reservation);
    }

    public function deleteReservation(int $id): Response
    {
        $reservation = $this->entityManager->getRepository(Reservation::class)->find($id);
        if (!$reservation) {
            return $this->json(['error' => 'Reservation not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($reservation);
        $this->entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
