<?php
namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Car;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/reservations')]
class ReservationController extends AbstractController
{
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    #[Route('', methods: ['POST'])]
    public function createReservation(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $carId = $data['carId'];
        $startDate = new \DateTime($data['startDate']);
        $endDate = new \DateTime($data['endDate']);

        if (!$this->reservationService->isCarAvailable($carId, $startDate, $endDate)) {
            return $this->json(['error' => 'Car is not available'], Response::HTTP_CONFLICT);
        }

        $reservation = new Reservation();
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setUser($this->getUser());
        $reservation->setCar($this->getDoctrine()->getRepository(Car::class)->find($carId));
        $this->getDoctrine()->getManager()->persist($reservation);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reservation);
    }
}
