<?php

namespace webhubworks\ohdear\health\checks;

use Illuminate\Support\Collection;
use OhDear\HealthCheckResults\CheckResult;
use yii\base\Exception;

class AbandonedPackagesCheck extends Check
{

    use RunsComposer;

    /**
     * @throws Exception
     */
    public function run(): CheckResult
    {
        $auditResult = $this->getAuditResult();
        $abandonedPackages = $auditResult['abandoned'] ?? [];

        $abandonedPackages = collect($abandonedPackages)->map(function (string $newPackage, string $abandonedPackage) {
            $whyResult = $this->getWhyResult($abandonedPackage);
            $packageInformation = $this->getPackageInformation($abandonedPackage);

            $requiredByPackage = $whyResult[0];
            $requiredByPackageVersion = $whyResult[1];
            $installedVersionConstraint = trim($whyResult[4], "()");
            $installedVersion = $packageInformation['versions'][0] ?? null;

            return [
                'installedVersion' => $installedVersion,
                'installedVersionConstraint' => $installedVersionConstraint,
                'requiredBy' => [
                    'packageName' => $requiredByPackage,
                    'installedVersion' => $requiredByPackageVersion,
                ]
            ];
        });

        return (new CheckResult(
            name: 'AbandonedPackages',
            label: 'Abandoned Packages',
            shortSummary: $this->getShortSummary($abandonedPackages),
            status: $this->getCheckStatus($abandonedPackages),
            meta: $this->getMetaValueForPackages($abandonedPackages),
        ));
    }

    private function getMetaValueForPackages(Collection $packages): array
    {
        return $packages->mapWithKeys(fn ($package, $packageName) => [
            $packageName => [
                'requiredBy' => $package['requiredBy'],
            ],
        ])->toArray();
    }

    private function getShortSummary(Collection $abandonedPackages): string
    {
        if ($abandonedPackages->isEmpty()) {
            return 'No abandoned packages found.';
        }

        if ($abandonedPackages->count() === 1) {
            return '1 abandoned package found!';
        }

        return $abandonedPackages->count() . ' abandoned packages found!';
    }

    private function getCheckStatus(\Tightenco\Collect\Support\Collection|Collection $abandonedPackages): string
    {
        if ($abandonedPackages->isEmpty()) {
            return CheckResult::STATUS_OK;
        }

        return CheckResult::STATUS_FAILED;
    }
}
