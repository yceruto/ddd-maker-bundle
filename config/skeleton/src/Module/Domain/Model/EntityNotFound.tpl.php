<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Exception\EntityNotFound;
use Symfony\Component\Translation\TranslatableMessage;

class <?= $class_name; ?> extends EntityNotFound
{
    public static function create(<?= $entity_type; ?>Id $id): self
    {
        return parent::createTranslatable(
            sprintf('The <?= $entity_name; ?> <%s> does not exist', $id->value()),
            new TranslatableMessage('<?= $entity_name; ?>.not_found', ['identifier' => $id->value()])
        );
    }
}
