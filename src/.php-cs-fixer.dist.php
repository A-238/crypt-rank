<?php

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR2' => true,
    'no_unused_imports' => true,
])
    ->setFinder(PhpCsFixer\Finder::create()
        ->exclude('vendor')
        ->notPath('phpstorm.meta.php')
        ->notPath('_ide_helper.php')
        ->in(__DIR__)
    );
