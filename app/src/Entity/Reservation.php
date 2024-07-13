<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ReservationController;

#[ApiResource(
    normalizationContext: ['groups' => ['reservation:read']],
    denormalizationContext: ['groups' => ['reservation:write']],
    operations: [
        new Post(
            uriTemplate: '/reservations',
            controller: ReservationController::class . '::createReservation',
            denormalizationContext: ['groups' => ['reservation:write']],
            validationContext: ['groups' => ['Default', 'reservation:create']],
            openapiContext: [
                'summary' => 'Create a new reservation',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'carId' => ['type' => 'integer'],
                                    'startDate' => ['type' => 'string', 'format' => 'date-time'],
                                    'endDate' => ['type' => 'string', 'format' => 'date-time'],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ),
        new GetCollection(
            uriTemplate: '/users/{id}/reservations',
            controller: ReservationController::class . '::getUserReservations',
            normalizationContext: ['groups' => ['reservation:read']],
            openapiContext: [
                'summary' => 'Get user reservations',
            ]
        ),
        new Put(
            uriTemplate: '/reservations/{id}',
            controller: ReservationController::class . '::updateReservation',
            denormalizationContext: ['groups' => ['reservation:write']],
            validationContext: ['groups' => ['Default', 'reservation:update']],
            openapiContext: [
                'summary' => 'Update an existing reservation',
            ]
        ),
        new Delete(
            uriTemplate: '/reservations/{id}',
            controller: ReservationController::class . '::deleteReservation',
            openapiContext: [
                'summary' => 'Cancel an existing reservation',
            ]
        ),
    ]
)]
#[ORM\Entity]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Car::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private $car;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Groups(['reservation:read', 'reservation:write'])]
    private $startDate;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Groups(['reservation:read', 'reservation:write'])]
    private $endDate;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:read'])]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
