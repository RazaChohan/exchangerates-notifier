<?php

namespace App\Repository;

use App\Entity\ExchangeRate;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ExchangeRatesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    /***
     * Find all exchange rates by filters
     *
     * @param $baseCurrency
     * @param $date
     * @return mixed
     */
    public function findAllExchangeRatesByFilters($baseCurrency, $date)
    {
        $qb = $this->createQueryBuilder('e_r')
            ->andWhere('e_r.base = :baseCurrency')
            ->setParameter('baseCurrency', $baseCurrency);

        if(!empty($date)) {
            $qb =  $qb->andWhere('e_r.date = :date')
                        ->setParameter('date', $date);
        }
        $qb = $qb->getQuery();

        return $qb->execute();
    }
}