<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use <?= $root_namespace; ?>\Shared\Domain\Bus\Query\Response;
use <?= $aggregate_namespace; ?>\<?= $aggregate_type; ?>Dto;

/**
 * @psalm-immutable
 */
class <?= $class_name; ?> implements Response
{
    private <?= $aggregate_type; ?>Dto $<?= $aggregate_name; ?>;

    public function __construct(<?= $aggregate_type; ?>Dto $<?= $aggregate_name; ?>)
    {
        $this-><?= $aggregate_name; ?> = $<?= $aggregate_name; ?>;
    }

    public function <?= $aggregate_name; ?>(): <?= $aggregate_type; ?>Dto
    {
        return $this-><?= $aggregate_name; ?>;
    }
}
