parameters:

services:
    _defaults:
        autowire: true
        autoconfigure: true

    <?= $context ?>\:
        resource: '../src/<?= $context ?>/'
