# Contributing

Contributions are welcome. Please follow the workflow below before opening a pull request.

## Setup

Fork the repository, then clone your fork:

```bash
git clone https://github.com/YOUR_USERNAME/laravel-readable.git
cd laravel-readable
composer install
```

Add the original repository as `upstream`:

```bash
git remote add upstream https://github.com/Pharaonic/laravel-readable.git
```

## Choose the target branch

Use the branch matching the Laravel version you want to support.

```text
6.x → Laravel 6
7.x → Laravel 7
8.x → Laravel 8
9.x → Laravel 9
10.x → Laravel 10
11.x → Laravel 11
12.x → Laravel 12
```

Example:

```bash
git checkout 12.x
git pull upstream 12.x
```

Always start your work from the appropriate Laravel version branch.

## Create a working branch

Create a branch from the target version branch:

```bash
git checkout -b fix/size-rounding
```

Recommended prefixes:

```text
feature/
fix/
refactor/
test/
docs/
chore/
```

Examples:

```text
feature/human-number-locale
fix/size-rounding
refactor/time-length
test/blade-directives
docs/usage-examples
chore/update-dependencies
```

## Make your changes

- Keep each change focused.
- Follow the existing project structure and coding style.
- Add or update tests for behavior changes.
- Preserve backward compatibility whenever possible.
- Keep Laravel-specific functionality inside this package.
- Keep framework-agnostic formatting inside `pharaonic/php-readable`.
- Do not change an existing output unless it is wrong; add the old and new value to `tests/Unit/LegacyFixesTest.php`.
- Update `/docs` when the public API or usage changes.
- Update `CHANGELOG.md` under `Unreleased` when applicable.
- Do not introduce breaking changes without discussing them in an issue first.

If a change belongs to framework-agnostic formatting rather than the Laravel integration, it should normally be contributed to:

```text
pharaonic/php-readable
```

instead.

## Run checks

Before opening a pull request:

```bash
composer check
composer validate --strict
```

All checks must pass.

The package must also be tested against the Laravel version targeted by the branch.

For example:

```text
12.x → Laravel 12
```

## Commit your changes

Use clear and concise commit messages.

Examples:

```text
Add locale support to getCompactNumber
Fix size rounding at unit boundaries
Update Laravel 12 compatibility
Update usage documentation
```

Avoid vague commit messages such as:

```text
fix
update
changes
work
```

## Push and open a pull request

Push your working branch:

```bash
git push origin fix/size-rounding
```

Open the pull request against the same Laravel version branch you started from.

Example:

```text
fix/size-rounding
        ↓
       12.x
```

Do not submit the pull request against another Laravel version branch.

Do not submit the same change to multiple version branches unless requested by the maintainers.

## Pull request guidelines

Before submitting your pull request, make sure:

- The target Laravel branch is correct.
- Tests have been added or updated when necessary.
- All automated checks pass.
- Documentation has been updated when necessary.
- `CHANGELOG.md` has been updated when appropriate.
- The pull request contains only relevant changes.

Provide a clear description of:

- What was changed.
- Why the change was necessary.
- Which Laravel version is targeted.
- Any backward compatibility considerations.
- Any related issues.

If the pull request fixes an issue:

```text
Fixes #123
```

## Dependency changes

Changes to the supported versions of:

```text
PHP
Laravel
pharaonic/php-readable
```

should be made carefully.

Do not broaden or restrict dependency constraints without considering the compatibility policy of the target branch.

Changes to framework-agnostic formatting should be implemented in `pharaonic/php-readable` first and then consumed by `laravel-readable`.

## Breaking changes

Breaking changes should not be introduced without prior discussion.

Open an issue first and explain:

- The current behavior.
- The proposed behavior.
- Why the breaking change is necessary.
- The affected Laravel versions.
- Possible migration paths.

Breaking changes may be deferred to a future version branch.

## Documentation

Documentation lives in:

```text
/docs
```

If your change affects the public API, helpers, Blade directives, or user-facing behavior, update the corresponding documentation in the same pull request.

Code and documentation should remain synchronized.

Code and documentation should remain synchronized.

## Security

Do not report security vulnerabilities through public GitHub issues.

See [SECURITY.md](SECURITY.md).

## License

By contributing to this project, you agree that your contributions will be licensed under the same license as the project.