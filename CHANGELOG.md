# Oh Dear Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 4.5.2 - 2024-11-21

### Changed
- Moved plugin registrations depending on Craft's initialization into onInit() method

## 4.5.1 - 2024-07-18

### Fixed

- Missing custom plugin name in widget 

## 4.5.0 - 2024-07-10

### Added
- The plugin name can now be customised in the settings.

### Fixed
- Adjusted cert health check to work with the a change in the Oh Dear API

## 4.4.0 - 2024-07-10

### Added
- Individual plugins can now be ignored by its handle in the health check for available updates.

## 4.3.4 - 2024-03-26

### Fixed
- Bug where calling the health check endpoint unauthenticated failed due to not resolving an ENV variable.

## 4.3.3 - 2024-03-25

### Fixed
- Bug where the authentication via the Oh Dear API failed due to not resolving an ENV variable.

## 4.3.2 - 2023-11-22

### Fixed
- Duplicate naming in Queue Health Checks (thanks @jorisnoo)
- Bug where giving a site domain in Oh Dear a trailing slash lead to a double slash in the Health Report URL

## 4.3.1 - 2023-11-08

### Changed
- Prioritise critical available updates over total update count when determining the failed or warning state in the Available Updates Health Check

## 4.3.0 - 2023-10-07

### Added
- New health checks: Queue Health, Redis Connection (See [docs for Application Health Checks](https://github.com/webhubworks/craft-ohdear/wiki/Application-health-checks))
-  Added delete action to the maintenance  console commands
- Added section about the latest queue heartbeat to the App Health utility page
### Changed
- Improve error handling in console commands

### Fixed
- Fixed bug  in Server Requirements Check where the `$warnForOptionalRequirements` setting was not respected
-  Fixed bug in  maintenance console command where the status of a maintenance period was not calculated properly due to timezone differences

## 4.2.0 - 2023-10-05

### Added
- Added API validations for API token and  site ID fields in settings page
- Added feature for badge counts in the CP navigation, added  settings to disable this feature
### Changed
- Updated `ohdearapp/ohdear-php-sdk` and `ohdearapp/health-check-results`
- Improved  secret check in health check results endpoint
- Improve error handling for the internal API if the APIT token or site ID are invalid

### Fixed
- Fixed bug where empty Oh Dear browser window objects were leaked into  guest web requests (issue #47, thanks @jorisnoo)
- Fix Oh Dear deep links in settings
- Handle unsupported queue drivers for the failed jobs check

## 4.1.0 - 2023-04-14
### Added
- As per issue #30 added support for granular Control Panel permissions including:
  - View, toggle and request permissions for each check
  - View permission for the Application Health check utility
  - View permission for the Overview page
### Fixed
  - Check card report links now respect a `cpTrigger` set to `null` (issue #40)

## 4.0.2 - 2022-10-03
### Fixed
- Fixed missing type definition in controller property ([PR #32](https://github.com/webhubworks/craft-ohdear/pull/32), thanks @jorisnoo)

## 4.0.1 - 2022-05-23
### Fixed
- Fixed bug where the settings page quick links broke when setting the site ID in the settings to an env var

## 4.0.0 - 2022-05-09
### Added
- Added support for Craft CMS 4

### Changed
- Type hints and code format
- Updated permission registration for Craft 4

## 2.0.2 - 2022-05-09
### Changed
- Improved settings page
- Changed default health check URL

## 2.0.1 - 2022-05-06
### Fixed
- Fixed an issues with API routes when running Craft in Headless Mode

### Changed
- Improved German translation

## 2.0.0 - 2022-03-16
### Added
- Application health checks
  - Added overview card
  - Added app health report
  - Added the ability to enable built-in application health checks, including available updates, dev mode, environment, failed jobs, server requirements, used disk space
  - Added the ability to define custom application health checks
- Performance checks
  - Added overview card
  - Added performence report
- Added German translation 🇩🇪

### Changed
- The plugin now requires PHP 8+ due to new dependencies
- Improved widget to provide access to newly added checks

### Fixed
- Oh Dear changed their links, fixed that in the CP
- Fixed bug in uptime chart with shifted week days

## 1.2.2 - 2020-10-23
### Fixed
- PSR-4 compliance

## 1.2.1 - 2020-10-04
### Fixed
- Fixed a validation issue that occurred when settings the site ID as env var

## 1.2.0 - 2020-10-04
### Added
- Settings can now be environment variables

### Changed
- Improved uptime heatmap UI
- Settings page has now auto-suggest fields for API token and site ID
    - The new settings page should apply existing settings without problems.
- Available sites are no longer loaded from Oh Dear when an API token is provided on the settings page, instead the user has to provide the site ID directly
    - Here's why: As a provider for Craft maintenance we have a lot of client sites monitored in Oh Dear. When installing Craft Oh Dear on their sites, none of the client's employees should be able to see the site names from other clients on the settings page. Admittedly, there is a permission to not allow the settings page for users, but not for admin users.
    
### Fixed
- Fixed an issue that ignored widget settings on which checks are visible

## 1.1.2 - 2020-10-03
### Fixed
- Fixed incompatibilities with a new version of the Oh Dear API

## 1.1.1 - 2020-08-18
### Fixed
- Fixed a bug where a custom CP trigger leads to broken links (in a broken link monitor OMG) in the control panel
- Fixed minor bug in check cards

## 1.1.0 - 2020-05-28
### Added
- Added error handling if API key in use has been accidentally deleted in Oh Dear
### Changed
- Improved algorithm that tries to find the element edit page of a broken link or mixed content item, it searches in entries, global sets, matrix blocks and assets now
### Fixed
- Fixed typo in the mixed content report component
- Minor UI improvements

## 1.0.2 - 2020-05-27
### Fixed
- Fixed a bug that broke the CLI

## 1.0.1 - 2020-05-27
### Fixed
- Fixed possible UI error if no broken link or mixed content element could be found
- Fixed error if modifying element edit page redirect but request referrer is unavailable
- Prepare broken link and mixed content element finding algorithm for further improvement

## 1.0.0 - 2020-05-26
### Added
- Initial release
