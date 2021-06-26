<?php

declare (strict_types=1);
namespace RectorPrefix20210626\Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
final class CallablePhpDocNodeVisitor extends \RectorPrefix20210626\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var callable
     */
    private $callable;
    /**
     * @var string|null
     */
    private $docContent;
    public function __construct(callable $callable, ?string $docContent = null)
    {
        $this->docContent = $docContent;
        $this->callable = $callable;
    }
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $node) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        $callable = $this->callable;
        return $callable($node, $this->docContent);
    }
}
