<?php declare(strict_types=1);

namespace Rector\Rector\Dynamic;

use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Node\Attribute;
use Rector\NodeAnalyzer\ClassAnalyzer;
use Rector\Rector\AbstractRector;

/**
 * Useful when parent class or interface gets new typehints,
 * that breaks contract with child instances.
 *
 * E.g. interface SomeInterface
 * {
 *      public read($content);
 * }
 *
 * After
 *      public read(string $content);
 */
final class ParentTypehintedArgumentRector extends AbstractRector
{
    /**
     * class => [
     *      method => [
     *           argument => typehting
     *      ]
     * ]
     *
     * @var string[]
     */
    private $typehintForArgumentByMethodAndClass = [];

    /**
     * @var ClassAnalyzer
     */
    private $classAnalyzer;

    /**
     * @param mixed[] $typehintForArgumentByMethodAndClass
     */
    public function __construct(array $typehintForArgumentByMethodAndClass, ClassAnalyzer $classAnalyzer)
    {
        $this->typehintForArgumentByMethodAndClass = $typehintForArgumentByMethodAndClass;
        $this->classAnalyzer = $classAnalyzer;
    }

    public function isCandidate(Node $node): bool
    {
        if (! $node instanceof ClassMethod) {
            return false;
        }

        /** @var Class_ $classNode */
        $classNode = $node->getAttribute(Attribute::CLASS_NODE);

        $parentTypes = $this->classAnalyzer->resolveParentTypes($classNode);

        return $this->isTypeMatch($parentTypes);
    }

    /**
     * @param ClassMethod $classMethodNode
     */
    public function refactor(Node $classMethodNode): ?Node
    {
        /** @var Class_ $classMethodNode */
        $classNode = $classMethodNode->getAttribute(Attribute::CLASS_NODE);

        $classParentTypes = $this->classAnalyzer->resolveParentTypes($classNode);

        $matchingTypes = $this->getMatchingTypesForClassNode($classParentTypes);

        $methodName = $classMethodNode->name->toString();

        foreach ($matchingTypes as $matchingType) {
            $configuration = $this->typehintForArgumentByMethodAndClass[$matchingType];

            foreach ($configuration as $method => $parametersToTypehints) {
                if ($methodName === $method) {
                    return $this->processClassMethodNodeWithTypehints($classMethodNode, $parametersToTypehints);
                }
            }
        }

        return $classMethodNode;
    }

    /**
     * @return string[]
     */
    private function getClasses(): array
    {
        return array_keys($this->typehintForArgumentByMethodAndClass);
    }

    /**
     * @param string[] $types
     */
    private function isTypeMatch(array $types): bool
    {
        return (bool) $this->getMatchingTypesForClassNode($types);
    }

    /**
     * @param string[] $types
     * @return string[]
     */
    private function getMatchingTypesForClassNode(array $types): array
    {
        return array_intersect($types, $this->getClasses());
    }

    /**
     * @param string[] $parametersToTypehints
     */
    private function processClassMethodNodeWithTypehints(
        ClassMethod $classMethodNode,
        array $parametersToTypehints
    ): ClassMethod {
        /** @var Param $param */
        foreach ($classMethodNode->params as $param) {
            $parameterName = $param->var->name;

            if (! isset($parametersToTypehints[$parameterName])) {
                continue;
            }

            $newTypehint = $parametersToTypehints[$parameterName];

            $param->type = BuilderHelpers::normalizeType($newTypehint);
        }

        return $classMethodNode;
    }
}
