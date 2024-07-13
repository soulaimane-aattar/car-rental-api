<?php
namespace App\Service;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;

class ReservationService
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function isCarAvailable(int $carId, \DateTime $startDate, \DateTime $endDate): bool
    {
        $reservations = $this->reservationRepository->findBy(['car' => $carId]);
        foreach ($reservations as $reservation) {
            if (
                ($startDate >= $reservation->getStartDate() && $startDate <= $reservation->getEndDate()) ||
                ($endDate >= $reservation->getStartDate() && $endDate <= $reservation->getEndDate())
            ) {
                return false;
            }
        }
        return true;
    }
}
