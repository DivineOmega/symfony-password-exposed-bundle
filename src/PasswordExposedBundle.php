<?php

namespace DivineOmega\PasswordExposed\Symfony;

use DivineOmega\PasswordExposed\Symfony\DependencyInjection\Compiler\HttpClientCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class PasswordExposedBundle
 *
 * @package DivineOmega\PasswordExposed\Symfony
 * @author  Nikita Loges
 */
class PasswordExposedBundle extends Bundle
{

    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new HttpClientCompiler());
    }

}
