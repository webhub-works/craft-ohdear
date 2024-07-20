<?php

namespace webhubworks\ohdear\health\checks;

use Illuminate\Support\Collection;
use OhDear\HealthCheckResults\CheckResult;
use yii\base\Exception;

class CveCheck extends Check
{
    use RunsComposer;

    /**
     * @throws Exception
     */
    public function run(): CheckResult
    {
        $auditResult = $this->getAuditResult();
        $advisoriesPerPackage = $auditResult['advisories'] ?? [];
        $abandonedPackages = $auditResult['abandoned'] ?? [];

        $advisoriesPerPackage = collect($advisoriesPerPackage)->map(function ($advisories, $packageName) {

            $whyResult = $this->getWhyResult($packageName);
            $packageInformation = $this->getPackageInformation($packageName);

            $requiredByPackage = $whyResult[0];
            $requiredByPackageVersion = $whyResult[1];
            $installedVersionConstraint = trim($whyResult[4], "()");
            $installedVersion = $packageInformation['versions'][0] ?? null;

            return [
                'advisories' => $advisories,
                'installedVersion' => $installedVersion,
                'installedVersionConstraint' => $installedVersionConstraint,
                'requiredBy' => [
                    'packageName' => $requiredByPackage,
                    'installedVersion' => $requiredByPackageVersion,
                ]
            ];
        });

        return (new CheckResult(
            name: 'SecurityVulnerabilities',
            label: 'Security Vulnerabilities',
            shortSummary: $this->getShortSummary($advisoriesPerPackage),
            status: $this->getCheckStatus($advisoriesPerPackage),
            meta: $advisoriesPerPackage->mapWithKeys(fn ($package, $packageName) => [
                $packageName => $this->getMetaValueForPackage($package),
            ])->toArray(),
        ));
    }

    private function getMetaValueForPackage(array $package): string
    {
        if (empty($package['advisories'])) {
            return 'No security vulnerabilities';
        }

        if (count($package['advisories']) === 1) {
            return '1 security vulnerability';
        }

        return count($package['advisories']) . ' security vulnerabilities';
    }

    private function getShortSummary(Collection $advisoriesPerPackage): string
    {
        if ($advisoriesPerPackage->isEmpty()) {
            return 'No security vulnerabilities found.';
        }

        if ($advisoriesPerPackage->count() === 1) {
            return '1 package with security vulnerabilities found!';
        }

        return $advisoriesPerPackage->count() . ' packages with security vulnerabilities found!';
    }

    private function getCheckStatus(\Tightenco\Collect\Support\Collection|Collection $advisoriesPerPackage): string
    {
        if ($advisoriesPerPackage->isEmpty()) {
            return CheckResult::STATUS_OK;
        }

        return CheckResult::STATUS_FAILED;
    }
}
