---
view: components.packages.quick-look
title: A quick look
subtitle: Every formatter is a Blade directive, a global helper and a static method.
file: resources/views/files/show.blade.php
language: blade
code: |
  <h1>{{ $file->name }}</h1>

  <p>Size: @readableFileSize($file->size)</p>                  {{-- 1.5 KB --}}
  <p>Downloads: @readableCompactNumber($file->downloads)</p>  {{-- 77K --}}
  <p>Uploaded: @readableDate($file->created_at)</p>         {{-- 24 April 2020 --}}
  <p>@readableRelativeDateTime($file->updated_at)</p>           {{-- 2 hours before --}}

  {{-- Or in PHP --}}
  {{ readable_file_size($file->size, false) }}                    {{-- 1.46 KiB --}}
---
