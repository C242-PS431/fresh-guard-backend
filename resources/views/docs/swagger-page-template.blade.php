<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('tilte')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    #swagger-ui {
      width: 100%;
      height: 100vh;
    }
  </style>
</head>

<body>
  <div id="swagger-ui"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui-bundle.min.js"></script>
  <script>
    let spec = @yield('open-api');

    SwaggerUIBundle({
      spec,
      dom_id: '#swagger-ui'
    });
  </script>
</body>

</html>