<?php

declare (strict_types=1);
namespace RectorPrefix20210517\Symplify\ConsolePackageBuilder\Bundle;

use RectorPrefix20210517\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210517\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210517\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \RectorPrefix20210517\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20210517\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210517\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}