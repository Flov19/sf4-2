<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Récupérer les nouveaux produits: produits créés il y a moins d'un mois
     * Retourne un tableau d'objet product
     * @return Product[]
     */
    public function findNews(){
        // Création d'un QueryBuilder (constructeur de requête)
        return $this->createQueryBuilder('p')  # "p" = alias de Product
            ->where('p.createdAt >= :last_month')
            ->setParameter('last_month', new \DateTime('-1 month'))
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()                                #Obtenir la requête
            ->getResult();                              #Obtenir un tableau d'entités
        }
}
