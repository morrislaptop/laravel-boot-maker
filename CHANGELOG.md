# Changelog

All notable changes to `laravel-boot-maker` will be documented in this file.

## v0.6.0 - 2026-09-07

Agent-facing docs, and two concerns that could not run.

### What's Changed

* feat: ship Laravel Boost guidelines and a `partial-boot-testing` skill by @ekvedaras in https://github.com/morrislaptop/laravel-boot-maker/pull/38
* fix: fall back to the framework's `EventServiceProvider` when the app has none by @ekvedaras in https://github.com/morrislaptop/laravel-boot-maker/pull/38
* fix: import `FullBootRequired` from its own namespace in the `Console` concern by @ekvedaras in https://github.com/morrislaptop/laravel-boot-maker/pull/38
* ci: run the matrix through bash so the Laravel caret survives on Windows by @ekvedaras in https://github.com/morrislaptop/laravel-boot-maker/pull/38

### Laravel Boost

The package now ships its own [Boost](https://laravel.com/framework/docs/boost#third-party-package-skills) resources, so an agent working in an app that installs it knows the workflow instead of guessing at concerns:

* `resources/boost/guidelines/core.blade.php` — always loaded, short: the base class, the concern convention, and which concerns refuse on purpose.
* `resources/boost/skills/partial-boot-testing/` — on demand: the one-file-at-a-time conversion loop, when a test cannot be converted, and the error-to-concern table.

Existing Boost users pick these up with `php artisan boost:update --discover`.

### Upgrading

No breaking changes. Nothing to do beyond `composer update`, plus `boost:update --discover` if you want the agent resources.

**Full Changelog**: https://github.com/morrislaptop/laravel-boot-maker/compare/v0.5.0...v0.6.0

## v0.5.0 - 2026-03-22

- Laravel 13
- PHP >= 8.3
- Test with PHP 8.5

## v0.4.0 - 2025-04-07

### What's Changed

* feat!: laravel 12 by @ekvedaras in https://github.com/morrislaptop/laravel-boot-maker/pull/25

### New Contributors

* @ekvedaras made their first contribution in https://github.com/morrislaptop/laravel-boot-maker/pull/25

**Full Changelog**: https://github.com/morrislaptop/laravel-boot-maker/compare/v0.3.0...v0.4.0

## v0.3.0 - 2024-08-09

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.1.0 to 2.2.0 by @dependabot in https://github.com/morrislaptop/laravel-boot-maker/pull/9
* Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/morrislaptop/laravel-boot-maker/pull/10
* Bump dependabot/fetch-metadata from 1.4.0 to 1.5.1 by @dependabot in https://github.com/morrislaptop/laravel-boot-maker/pull/11
* Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/morrislaptop/laravel-boot-maker/pull/13
* Bump stefanzweifel/git-auto-commit-action from 4 to 5 by @dependabot in https://github.com/morrislaptop/laravel-boot-maker/pull/16
* Bump aglipanci/laravel-pint-action from 2.2.0 to 2.3.1 by @dependabot in https://github.com/morrislaptop/laravel-boot-maker/pull/17
* Bump aglipanci/laravel-pint-action from 2.3.1 to 2.4 by @dependabot in https://github.com/morrislaptop/laravel-boot-maker/pull/20
* update illuminate/contracts to support ^11.0 by @eithed in https://github.com/morrislaptop/laravel-boot-maker/pull/23

### New Contributors

* @eithed made their first contribution in https://github.com/morrislaptop/laravel-boot-maker/pull/23

**Full Changelog**: https://github.com/morrislaptop/laravel-boot-maker/compare/v0.2.0...v0.3.0

## v0.2.0 - 2023-02-28

### What's Changed

- PHP 8.2 and Laravel 10 support by @morrislaptop in https://github.com/morrislaptop/laravel-boot-maker/pull/8

**Full Changelog**: https://github.com/morrislaptop/laravel-boot-maker/compare/v0.1.0...v0.2.0

## v0.1.0 - 2022-08-05

Initial release.
