<!DOCTYPE html>
<html lang="en" class="bg-body-light font-Outfit">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="/images/UI/favicon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'/>
    <script src="https://cdn.jsdelivr.net/npm/pdfkit@0.10.0/js/pdfkit.standalone.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/svg-to-pdfkit@0.1.8/source.js"></script>
    @if (config("app.env") !== "local")
        <link rel="stylesheet" href="/build/{{getAssets()['css']}}">
        <script src="/build/{{getAssets()['js']}}" type="module"></script>
    @else
        @vite('resources/js/app.js')
    @endif
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>
