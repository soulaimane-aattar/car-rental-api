<?php
namespace App\Tests\Service;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    public function testIsCarAvailable()
    {
        $reservationRepository = $this->createMock(ReservationRepository::class);

        // Define the mock behavior for findByCarAndDateRange
        $reservationRepository->method('findByCarAndDateRange')
            ->will($this->returnCallback(function($carId, $startDate, $endDate) {
                if ($carId == 1 && $startDate == new \DateTime('2022-01-05') && $endDate == new \DateTime('2022-01-15')) {
                    return [
                        (new Reservation())->setStartDate(new \DateTime('2022-01-01'))->setEndDate(new \DateTime('2022-01-10'))
                    ];
                }
                if ($carId == 1 && $startDate == new \DateTime('2022-01-11') && $endDate == new \DateTime('2022-01-15')) {
                    return [];
                }
                return [];
            }));

        $reservationService = new ReservationService($reservationRepository);

        // Test that the car is not available during overlapping dates
        $this->assertFalse($reservationService->isCarAvailable(1, new \DateTime('2022-01-05'), new \DateTime('2022-01-15')));

        // Test that the car is available when there is no overlap
        $this->assertTrue($reservationService->isCarAvailable(1, new \DateTime('2022-01-11'), new \DateTime('2022-01-15')));
    }
}
