<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use Doctrine\ORM\EntityManagerInterface;
use <?= $entity_class; ?>;
use <?= $entity_class; ?>Id;
use <?= $entity_class; ?>Repository;

class <?= $class_name; ?> implements <?= $entity_type; ?>Repository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(<?= $entity_type; ?> $<?= $entity_name; ?>): void
    {
        $this->em->persist($<?= $entity_name; ?>);
    }

    public function remove(<?= $entity_type; ?> $<?= $entity_name; ?>): void
    {
        $this->em->remove($<?= $entity_name; ?>);
    }

    public function ofId(<?= $entity_type; ?>Id $id): ?<?= $entity_type."\n"; ?>
    {
        return $this->em->find(<?= $entity_type; ?>::class, $id->value());
    }
}
