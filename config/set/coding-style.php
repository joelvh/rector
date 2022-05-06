<?php

declare (strict_types=1);
namespace RectorPrefix20220506;

use Rector\CodingStyle\Rector\Assign\PHPStormVarAnnotationRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector;
use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector;
use Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector;
return static function (\Rector\Config\RectorConfig $rectorConfig) : void {
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Assign\PHPStormVarAnnotationRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\If_\NullableCompareToNullRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector::class);
    $rectorConfig->rule(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector::class);
    $rectorConfig->ruleWithConfiguration(\Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector::class, ['php_sapi_name' => 'PHP_SAPI', 'pi' => 'M_PI']);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector::class);
};
