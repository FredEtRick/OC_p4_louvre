<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function getReservationsFromMail($mail)
    {
        $query = $this->_em->createQuery("SELECT r FROM App\Entity\Reservation r WHERE r.mail = :mail AND r.visitDay >= DATE_ADD(CURRENT_DATE(), (-1), 'day') ORDER BY r.visitDay ASC");
        $query->setParameter('mail', $mail);

        return $query->getResult();
    }

    public function countVisitorsOndate($visitDay)
    {
        $query = $this->_em->createQuery("SELECT COUNT(r) as nbReservations FROM App\Entity\Reservation r WHERE r.visitDay = :visitDay");
        $query->setParameter('visitDay', $visitDay);

        return $query->getOneOrNullResult()["nbReservations"];
    }
}
