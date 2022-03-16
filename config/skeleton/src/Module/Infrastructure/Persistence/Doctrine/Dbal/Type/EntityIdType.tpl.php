<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $entity_class; ?>Id;
use <?= $root_namespace; ?>\Shared\Infrastructure\Persistence\Doctrine\Dbal\Type\UuidType;

class <?= $class_name; ?> extends UuidType
{
    public function getName(): string
    {
        return '<?= $entity_name; ?>_id';
    }

    protected function getUidClass(): string
    {
        return <?= $entity_type; ?>Id::class;
    }
}
