<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\ValueObject\Uuid;

/**
 * @psalm-immutable
 */
class <?= $class_name; ?> extends Uuid
{
}
