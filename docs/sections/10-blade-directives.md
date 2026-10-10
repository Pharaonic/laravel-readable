## Blade Directives

Every formatter has a directive that takes the method's arguments and echoes the result.

```blade title="resources/views/posts/show.blade.php"
<article>
    <h1>{{ $post->title }}</h1>
    <p>
        @ReadableDate($post->published_at)
        · @ReadableHumanNumber($post->views, true) views
        · @ReadableTimeLength($post->reading_seconds) read
    </p>
</article>
```

Directives work inline with text:

```blade
<span>Size: @ReadableSize($file->size).</span> {{-- Size: 1.5 KB. --}}
```

The available directives are `@ReadableNumber`, `@ReadableHumanNumber`, `@ReadableNumberToString`, `@ReadableDecimal`, `@ReadableDecInt`, `@ReadableDate`, `@ReadableTime`, `@ReadableDateTime`, `@ReadableDiffDateTime`, `@ReadableTimeLength`, `@ReadableDateTimeLength` and `@ReadableSize`.

:::warning Escaping
Directives echo the result without `e()`, like `{!! !!}`. That lets you use an entity as a delimiter, such as `@ReadableNumber($n, '&nbsp;')`, but never pass user input as a delimiter or decimal point. Use `{{ ReadableNumber($n, $delimiter) }}` when you need escaping.
:::

:::info Null Output
`@ReadableSize(-1)` prints nothing, because `getSize()` returns `null` for negative sizes.
:::
