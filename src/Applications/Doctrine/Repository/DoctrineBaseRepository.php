<?php

namespace App\Applications\Doctrine\Repository;

use App\Applications\Common\Repository\BaseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class DoctrineBaseRepository extends ServiceEntityRepository implements BaseRepository
{
    /**
     * @var RegistryInterface
     */
    protected $registry;
    /** @var string */
    protected $class;

    public function saveBatch(array $List): void
    {
        $em = $this->registry->getEntityManager();

        foreach ($List as $item) {
            $em->persist($item);
        }

        $em->flush();
    }

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, $this->class);
        $this->registry = $registry;
    }

    public function createQueryBuilder($alias = 'o', $indexBy = null): QueryBuilder
    {
        return parent::createQueryBuilder($alias, $indexBy);
    }

    public function save($object): void
    {
        $em = $this->registry->getEntityManager();

        $em->persist($object);
        $em->flush();
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function new(...$args)
    {
        $class = $this->getClass();
        return new $class(...$args);
    }
}
