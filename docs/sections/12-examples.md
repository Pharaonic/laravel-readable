## Examples

### 1. File Manager

Show each upload's size, age and owner-friendly date.

- ===Controller

  ```php title="app/Http/Controllers/FileController.php"
  namespace App\Http\Controllers;

  use App\Models\File;

  class FileController extends Controller
  {
      public function index()
      {
          return view('files.index', [
              'files' => File::latest()->paginate(20),
              'used' => File::sum('size'),
          ]);
      }
  }
  ```

- ===Blade View

  ```blade title="resources/views/files/index.blade.php"
  <p>Storage used: @readableFileSize((int) $used)</p>

  @foreach ($files as $file)
      <tr>
          <td>{{ $file->name }}</td>
          <td>@readableFileSize($file->size)</td>
          <td title="@readableDateTime($file->created_at, true)">
              @readableRelativeDateTime($file->created_at)
          </td>
      </tr>
  @endforeach
  ```

### 2. Social Counters

Truncated counters never overstate: 1999 followers is `1K`, not `2K`.

```blade title="resources/views/profiles/show.blade.php"
<ul>
    <li>@readableCompactNumber($user->followers_count) followers</li>
    <li>@readableCompactNumber($user->posts_count) posts</li>
    <li>@readableCompactNumber($user->likes_count, true) likes</li>
</ul>
```

### 3. Invoice Amounts in Words

Print the total in figures and in words, in the customer's language.

```php title="app/Models/Invoice.php"
public function getTotalInWordsAttribute(): string
{
    return readable_number_in_words((float) $this->total, $this->customer->locale);
}

public function getFormattedTotalAttribute(): string
{
    return readable_decimal((float) $this->total).' '.$this->currency;
}
```

:::warning intl
Customers with a non-English locale need the intl extension on the server.
:::

### 4. Video Lengths and Uptime

```php
readable_duration($video->duration_seconds, ' ', true);  // "1h 4m 12s"
readable_duration($server->uptime, ', ');                // "3 days, 4 hours, 12 minutes"
```

### 5. Times in the Viewer's Timezone

Store UTC and show each user their own time.

```blade title="resources/views/events/show.blade.php"
<p>
    Starts @readableDate($event->starts_at, auth()->user()->timezone)
    at @readableTime($event->starts_at, true, false, auth()->user()->timezone)
</p>
```

`$event->starts_at` is not changed, so later uses still see UTC.
