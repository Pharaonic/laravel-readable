---
name: Laravel Readable

action:
  label: View on Packagist
  href: "{package.packagistUrl}"

views: components.packages

breadcrumbs:
  - label: Home
    href: route:home
  - label: Packages
    href: route:packages.index
  - label: "{technology.name} Packages"
    href: "url:/packages/{technology.slug}"
  - label: "{package.name}"

card:
  topic: formatting
  icon: lines
  tags: readable human-readable number format file-size bytes duration time-length date datetime diff spell blade helpers
  description: Human-readable numbers, dates, durations and file sizes for Laravel, as static methods, helpers and Blade directives.

seo:
  title: "{package.fullName} - Human-Readable Formatting for Laravel"
  description: "{package.name} is a Laravel package that turns numbers, dates, durations and file sizes into human-readable text, with helpers and Blade directives. {package.downloadsShort}+ downloads, {package.license} licensed."
  keywords: laravel readable, human readable, number format, readable number, file size, readable bytes, time length, duration, date format, diff for humans, spell number, blade directive
  author: Pharaonic
  images:
    - "{package.cover}"
  openGraph:
    type: website
    siteName: Pharaonic
  twitter:
    card: summary_large_image

schema:
  "@type": SoftwareSourceCode
  name: "{package.name}"
  description: "{package.name} is a Laravel package that turns numbers, dates, durations and file sizes into human-readable text."
  image: "{package.cover}"
  codeRepository: "{package.githubUrl}"
  programmingLanguage: PHP
  runtimePlatform: "{technology.name}"
  version: "{package.version}"
  datePublished: "{package.publishedAt}"
  dateModified: "{package.updatedAt}"
  license: "https://opensource.org/licenses/{package.license}"
  isAccessibleForFree: true
  sameAs:
    - "{package.githubUrl}"
    - "{package.packagistUrl}"
  author:
    "@id": url:/#organization
  publisher:
    "@id": url:/#organization
  interactionStatistic:
    "@type": InteractionCounter
    interactionType: https://schema.org/DownloadAction
    userInteractionCount: "{package.downloads}"
---
