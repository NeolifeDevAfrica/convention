<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css') ?>">
  <title>Convention @ 2022 - Draws</title>
  <script type="text/javascript">
    const SITE_URL = '<?=site_url() ?>';
  </script>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Neolife Convention 2022 - Draws</a>

    <div class="collapse navbar-collapse">

      <ul class="navbar-nav mr-auto">

        <li class="nav-item active">
          <a class="nav-link" href="<?=site_url('/draws/form') ?>">Restart <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>

  <?php $this->load->view($page) ?>

</body>
</html>