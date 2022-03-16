<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Bus\Query\Response;

/**
* @psalm-immutable
*/
class <?= $class_name; ?> implements Response
{
    // ...
}
