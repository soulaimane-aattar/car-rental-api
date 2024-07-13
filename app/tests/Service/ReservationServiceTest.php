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
        $reservationRepository->method('findBy')->willReturn([
            (new Reservation())->setStartDate(new \DateTime('2022-01-01'))->setEndDate(new \DateTime('2022-01-10'))
        ]);

        $reservationService = new ReservationService($reservationRepository);
        $this->assertFalse($reservationService->isCarAvailable(1, new \DateTime('2022-01-05'), new \DateTime('2022-01-15')));
        $this->assertTrue($reservationService->isCarAvailable(1, new \DateTime('2022-01-11'), new \DateTime('2022-01-15')));
    }
}
