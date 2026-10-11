---
view: components.home.faq
badge: FAQ
title: "{package.name}"
highlight: Questions
subtitle: "Quick answers about installing and using {package.name}."
---

## What is {package.name}?

{card.description} It's a free, open-source {technology.name} package by Pharaonic.

## How do I install {package.name}?

Run `composer require {package.composer}` in your project's root directory.

## What does {package.name} require?

The latest release requires {package.requiresText}.

## Do I need the intl extension?

Only to spell numbers in a language other than English, such as `readable_number_in_words(21, 'ar')`. English spelling and every other formatter work without it.

## Are dates and durations translated?

Yes. Month names, day names and words such as `years` and `before` come from Carbon, which follows your application locale.

## Why does `readable_compact_number(1500)` print `1K`?

Without decimals the value is truncated to whole units, so a counter never shows more than it has. Pass `true` to show a rounded decimal: `readable_compact_number(1500, true)` prints `1.5K`.

## Is the Blade output escaped?

No. The directives echo the result as is, like `{!! !!}`, so you can pass HTML entities as a delimiter. Don't pass user input as a delimiter.

## Is {package.name} free to use?

Yes. {package.name} is open source under the {package.license} license, so you can use it in personal and commercial projects.

## Where can I find the {package.name} documentation?

Read the [{package.name} documentation]({package.docsUrl}) for setup, configuration, and usage examples.

## How do I report a bug or contribute to {package.name}?

Open an issue or a pull request on [GitHub]({package.githubUrl}), or ask in the [Pharaonic Discord](https://discord.gg/XQG9RhvEvf).
