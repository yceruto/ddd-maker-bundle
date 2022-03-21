<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use Doctrine\ORM\QueryBuilder;
use <?= $entity_class; ?>;

class <?= $class_name; ?> implements Doctrine<?= $entity_type; ?>Specification
{
    private int $offset;
    private int $limit;

    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function query(QueryBuilder $qb): iterable
    {
        return $qb->select('o')
            ->from(<?= $entity_type; ?>::class, 'o')
            ->getQuery()
            ->setFirstResult($this->offset)
            ->setMaxResults($this->limit)
            ->getResult();
    }
}
