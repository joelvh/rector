<?php declare(strict_types=1);

namespace Rector\PHPUnit\NodeFactory;

use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use Rector\NodeTypeResolver\StaticTypeToStringResolver;
use Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe;

final class DataProviderClassMethodFactory
{
    /**
     * @var BuilderFactory
     */
    private $builderFactory;

    /**
     * @var StaticTypeToStringResolver
     */
    private $staticTypeToStringResolver;

    /**
     * @var DocBlockManipulator
     */
    private $docBlockManipulator;

    public function __construct(
        BuilderFactory $builderFactory,
        StaticTypeToStringResolver $staticTypeToStringResolver,
        DocBlockManipulator $docBlockManipulator
    ) {
        $this->builderFactory = $builderFactory;
        $this->staticTypeToStringResolver = $staticTypeToStringResolver;
        $this->docBlockManipulator = $docBlockManipulator;
    }

    public function createFromRecipe(DataProviderClassMethodRecipe $dataProviderClassMethodRecipe): ClassMethod
    {
        $methodBuilder = $this->builderFactory->method($dataProviderClassMethodRecipe->getMethodName());
        $methodBuilder->makePublic();

        $classMethod = $methodBuilder->getNode();

        foreach ($dataProviderClassMethodRecipe->getArgs() as $arg) {
            $value = $arg->value;
            if ($value instanceof Array_) {
                foreach ($value->items as $arrayItem) {
                    $returnStatement = new Yield_($arrayItem->value);
                    $classMethod->stmts[] = new Expression($returnStatement);
                }
            }
        }

        $this->decorateClassMethodWithReturnTypeAndTag($classMethod, $dataProviderClassMethodRecipe);

        return $classMethod;
    }

    private function decorateClassMethodWithReturnTypeAndTag(
        ClassMethod $classMethod,
        DataProviderClassMethodRecipe $dataProviderClassMethodRecipe
    ): void {
        $classMethod->returnType = new Identifier('iterable');

        $providedType = $dataProviderClassMethodRecipe->getProvidedType();
        if ($providedType === null) {
            return;
        }

        $typesAsStrings = $this->staticTypeToStringResolver->resolveTypes([$providedType]);
        $this->docBlockManipulator->addReturnTag($classMethod, implode('|', $typesAsStrings));
    }
}
