<?= "<?php\n" ?>

namespace <?= $context; ?>\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class <?= $context; ?>WebTestCase extends WebTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        return new \Kernel(
            $options['environment'] ?? 'test',
            $options['debug'] ?? true,
            $options['context'] ?? '<?= $contextLower; ?>'
        );
    }
}
