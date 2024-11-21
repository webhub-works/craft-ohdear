<?php
/**
 * Oh Dear plugin for Craft CMS 4.x
 *
 * Integrate Oh Dear into Craft CMS.
 *
 * @link      https://webhub.de
 * @copyright Copyright (c) 2019 webhub GmbH
 */

namespace webhubworks\ohdear\models;

use Craft;
use craft\base\Model;
use craft\helpers\App;
use OhDear\PhpSdk\OhDear as OhDearSdk;
use OhDear\PhpSdk\Resources\Site;
use webhubworks\ohdear\OhDear;
use OhDear\PhpSdk\Exceptions\UnauthorizedException;
use OhDear\PhpSdk\Resources\User as OhDearUser;
use OhDear\PhpSdk\Resources\Site as OhDearSite;

/**
 * @author    webhub GmbH
 * @package   OhDear
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    public string $pluginName = 'Oh Dear';

    public string $apiToken = '';

    public string $selectedSiteId = '';

    public bool $showNavBadges = false;

    public ?string $healthCheckSecret = null;

    public array $healthChecks = [];

    /**
     * Determines if the plugin has an API key and
     * a selected site ID.
     */
    public function isValid(): bool
    {
        return ! empty($this->apiToken) && ! empty($this->selectedSiteId);
    }

    public function getSelectedSiteId(): string
    {
        return $this->selectedSiteId;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    public function getHealthReportUrl(string $healthReportUri): ?string
    {
        if (! $this->isValid()) {
            return null;
        }

        try {
            $site = OhDear::$plugin->api->getSite();
            if ($site instanceof Site) {
                return implode('/', [
                    rtrim($site->url, '/'),
                    ltrim($healthReportUri, '/'),
                ]);
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            ['pluginName', 'string'],
            ['pluginName', 'default', 'value' => 'Oh Dear'],
            [['showNavBadges'], 'boolean'],
            [['apiToken', 'selectedSiteId'], 'trim'],
            [['apiToken', 'selectedSiteId'], 'default', 'value' => ''],
            ['selectedSiteId', 'required', 'when' => function ($model) {
                return ! empty($model->apiToken);
            }],
            [['apiToken'], 'validApiToken'],
            [['selectedSiteId'], 'validSelectedSiteId'],
        ];
    }

    public function validApiToken($attribute, $params): void
    {
        try {
            OhDear::$plugin->settingsService->getMe(App::parseEnv($this[$attribute]));
        } catch (UnauthorizedException $e) {
            $this->addError('apiToken', 'API authentication failed.');
        } catch (\Exception $e) {
            $this->addError('apiToken', $e->getMessage());
        }
    }

    public function validSelectedSiteId($attribute, $params): void
    {
        if (! $this->isValid()) {
            return;
        }

        try {
            OhDear::$plugin->settingsService->getSite(
                App::parseEnv($this->apiToken),
                (int) App::parseEnv($this[$attribute])
            );
        } catch (UnauthorizedException $e) {
            $this->addError('selectedSiteId', 'API authentication failed.');
        } catch (\Exception $e) {
            $this->addError('selectedSiteId', $e->getMessage());
        }
    }
}
