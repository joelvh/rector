<?php

declare(strict_types=1);

namespace Rector\ChangesReporting\Output;

use Nette\Utils\Json;
use Rector\ChangesReporting\Annotation\AnnotationExtractor;
use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use Rector\Core\Configuration\Configuration;
use Symplify\SmartFileSystem\SmartFileSystem;

final class JsonOutputFormatter implements OutputFormatterInterface
{
    /**
     * @var string
     */
    public const NAME = 'json';

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;

    /**
     * @var AnnotationExtractor
     */
    private $annotationExtractor;

    public function __construct(
        Configuration $configuration,
        SmartFileSystem $smartFileSystem,
        AnnotationExtractor $annotationExtractor
    ) {
        $this->configuration = $configuration;
        $this->smartFileSystem = $smartFileSystem;
        $this->annotationExtractor = $annotationExtractor;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function report(ErrorAndDiffCollector $errorAndDiffCollector): void
    {
        $errorsArray = [
            'meta' => [
                'version' => $this->configuration->getPrettyVersion(),
                'config' => $this->configuration->getMainConfigFilePath(),
            ],
            'totals' => [
                'changed_files' => $errorAndDiffCollector->getFileDiffsCount(),
                'removed_and_added_files_count' => $errorAndDiffCollector->getRemovedAndAddedFilesCount(),
                'removed_node_count' => $errorAndDiffCollector->getRemovedNodeCount(),
            ],
        ];

        $fileDiffs = $errorAndDiffCollector->getFileDiffs();
        ksort($fileDiffs);
        foreach ($fileDiffs as $fileDiff) {
            $relativeFilePath = $fileDiff->getRelativeFilePath();

            $appliedRectorsWithChangelog = $fileDiff->getRectorClassesWithChangelogUrlAndRectorClassAsKey(
                $this->annotationExtractor
            );

            $errorsArray['file_diffs'][] = [
                'file' => $relativeFilePath,
                'diff' => $fileDiff->getDiff(),
                'applied_rectors' => $fileDiff->getRectorClasses(),
                'applied_rectors_with_changelog' => $appliedRectorsWithChangelog,
            ];

            // for Rector CI
            $errorsArray['changed_files'][] = $relativeFilePath;
        }

        $errors = $errorAndDiffCollector->getErrors();
        $errorsArray['totals']['errors'] = count($errors);

        $errorsData = $this->createErrorsData($errors);
        if ($errorsData !== []) {
            $errorsArray['errors'] = $errorsData;
        }

        $json = Json::encode($errorsArray, Json::PRETTY);

        $outputFile = $this->configuration->getOutputFile();
        if ($outputFile !== null) {
            $this->smartFileSystem->dumpFile($outputFile, $json . PHP_EOL);
        } else {
            echo $json . PHP_EOL;
        }
    }

    /**
     * @param mixed[] $errors
     * @return mixed[]
     */
    private function createErrorsData(array $errors): array
    {
        $errorsData = [];

        foreach ($errors as $error) {
            $errorData = [
                'message' => $error->getMessage(),
                'file' => $error->getRelativeFilePath(),
            ];

            if ($error->getRectorClass()) {
                $errorData['caused_by'] = $error->getRectorClass();
            }

            if ($error->getLine() !== null) {
                $errorData['line'] = $error->getLine();
            }

            $errorsData[] = $errorData;
        }

        return $errorsData;
    }
}
