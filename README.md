<p align="center"><a href="https://pharaonic.dev/packages/laravel/readable" target="_blank"><img src="https://raw.githubusercontent.com/Pharaonic/laravel-readable/develop/docs/cover.webp"></a></p>

<p align="center">
  <a href="https://php.net" target="_blank"><img src="https://img.shields.io/static/v1?label=PHP&message=8.0&color=blue&style=flat-square" alt="PHP Version : 8.0"></a>
  <a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/static/v1?label=Laravel&message=6.x&color=F05340&style=flat-square" alt="Laravel Version : 6.x"></a>
  <img src="https://img.shields.io/static/v1?label=License&message=MIT&color=brightgreen&style=flat-square" alt="License">
  <img src="https://github.com/Pharaonic/laravel-readable/actions/workflows/build.yml/badge.svg?branch=6.x" alt="Build">
  <br>
  <a href="https://packagist.org/packages/Pharaonic/laravel-readable" target="_blank"><img src="https://img.shields.io/static/v1?label=Packagist&message=pharaonic/laravel-readable&color=blue&logo=packagist&logoColor=white" alt="Source"></a>
  <a href="https://packagist.org/packages/pharaonic/laravel-readable" target="_blank"><img src="https://poser.pugx.org/pharaonic/laravel-readable/v" alt="Packagist Version"></a>
  <a href="https://packagist.org/packages/pharaonic/laravel-readable" target="_blank"><img src="https://poser.pugx.org/pharaonic/laravel-readable/downloads" alt="Packagist Downloads"></a>
</p>

<h3 align="center">Readable numbers, dates, durations and file sizes for Laravel.</h3>
<h5 align="center">Powered by <a href="https://pharaonic.dev/packages/php/readable" target="_blank">PHP Readable</a>.</h5>
<br>

## Installation

```bash
composer require pharaonic/laravel-readable
```

The service provider is registered automatically. There is nothing to publish.

## Usage

```php
use Pharaonic\Laravel\Readable\Readable;

Readable::getCompactNumber(77700);  // "77K"
Readable::getDuration(3661);        // "1 hour 1 minute 1 second"
readable_file_size(1500);           // "1.5 KB"
```

```blade
@readableDate($post->published_at) · @readableCompactNumber($post->views) views
```

## Documentation

Full documentation: [Laravel Readable Documentation](https://pharaonic.dev/packages/laravel/readable).

## Support & Security

See [SUPPORT.md](SUPPORT.md) and [SECURITY.md](SECURITY.md). Contributions are welcome; see [CONTRIBUTING.md](CONTRIBUTING.md).

## License

MIT. See [LICENSE](LICENSE).
