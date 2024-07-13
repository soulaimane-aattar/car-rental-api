<?php
namespace App\Service;

use App\Entity\Car;
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
        $reservations = $this->reservationRepository->findByCarAndDateRange($carId, $startDate, $endDate);

        return count($reservations) === 0;
    }
}
