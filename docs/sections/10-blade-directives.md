## Blade Directives

Every formatter has a directive that takes the method's arguments and echoes the result.

```blade title="resources/views/posts/show.blade.php"
<article>
    <h1>{{ $post->title }}</h1>
    <p>
        @readableDate($post->published_at)
        · @readableCompactNumber($post->views, true) views
        · @readableDuration($post->reading_seconds) read
    </p>
</article>
```

Directives work inline with text:

```blade
<span>Size: @readableFileSize($file->size).</span> {{-- Size: 1.5 KB. --}}
```

The available directives are `@readableNumber`, `@readableCompactNumber`, `@readableNumberInWords`, `@readableDecimal`, `@readableDecimalOrInteger`, `@readableDate`, `@readableTime`, `@readableDateTime`, `@readableRelativeDateTime`, `@readableDuration`, `@readableDateTimeLength` and `@readableFileSize`.

:::warning Escaping
Directives echo the result without `e()`, like `{!! !!}`. That lets you use an entity as a delimiter, such as `@readableNumber($n, '&nbsp;')`, but never pass user input as a delimiter or decimal point. Use `{{ readable_number($n, $delimiter) }}` when you need escaping.
:::

:::info Null Output
`@readableFileSize(-1)` prints nothing, because `getFileSize()` returns `null` for negative sizes.
:::
