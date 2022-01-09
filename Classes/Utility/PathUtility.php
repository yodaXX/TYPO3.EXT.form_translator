<?php

namespace R3H6\FormTranslator\Utility;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility as Typo3PathUtility;

final class PathUtility
{
    public static function makeAbsolute(string $path, string $basePath = ''): string
    {
        if (Typo3PathUtility::isAbsolutePath($path)) {
            return $path;
        }
        if (static::isExtensionPath($path)) {
            return GeneralUtility::getFileAbsFileName($path);
        }
        if (Typo3PathUtility::isAbsolutePath($basePath)) {
            if (!class_exists('Symfony\\Component\\Filesystem\\Path')) {
                require_once GeneralUtility::getFileAbsFileName('EXT:form_translator/Resources/Private/Php/Path.php');
            }
            return \Symfony\Component\Filesystem\Path::canonicalize(rtrim($basePath, '/') . '/' . $path);
        }
        $absPath = GeneralUtility::getFileAbsFileName($path);
        if ($absPath === '') {
            throw new \InvalidArgumentException('Could not make path "' . $path . '" absolute', 1641503695577);
        }
        return $absPath;
    }

    public static function getAbsPathForPersistenceIdentifier(string $persistenceIdentifier): string
    {
        if (static::isExtensionPath($persistenceIdentifier)) {
            return GeneralUtility::getFileAbsFileName($persistenceIdentifier);
        }

        /** @var ResourceFactory $resourceFactory */
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
        $file = $resourceFactory->getObjectFromCombinedIdentifier($persistenceIdentifier);
        return rtrim(Environment::getPublicPath(), '/') . '/' . ltrim($file->getPublicUrl(), '/');
    }

    public static function isExtensionPath(string $path): bool
    {
        return str_starts_with($path, 'EXT:');
    }

    private function __construct()
    {
    }
}
