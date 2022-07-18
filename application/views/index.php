<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css') ?>">
  <title>Convention @ 2022</title>
  <script type="text/javascript">
    const SITE_URL = '<?=site_url() ?>';
  </script>

  <style type="text/css">
    ::-webkit-input-placeholder {
      color: rgba(0,0,0,0.2) !important;
    }
    ::-moz-placeholder {
      color: rgba(0,0,0,0.2) !important;
    }
    :-ms-input-placeholder { /* IE 10+ */
      color: rgba(0,0,0,0.2) !important;
    }
    :-moz-placeholder { /* Firefox 18- */
      color: rgba(0,0,0,0.2) !important;
    }

    .order_id{

      font-size:25px;
      font-weight: lighter;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?=site_url() ?>">Convention 2022</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php if(Login::check()): ?>
      <div class="collapse navbar-collapse">

        <ul class="navbar-nav mr-auto">

          <li class="nav-item active">
            <a class="nav-link" href="<?=site_url('/') ?>">Home <span class="sr-only">(current)</span></a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?=site_url('/home/stats') ?>">View Statistics</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?=site_url('/fetch') ?>">Upload New Tickets</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="<?=site_url('/draws/form') ?>">Draws</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?=site_url('/auth/logout') ?>">Logout</a>
          </li>

        </ul>

        <form class="form-inline my-2 my-lg-0">
          <h4 class='text-muted'>Logged as <?=$this->session->userdata('name') ?></h4>
        </form>

      </div>

    <?php endif ?>
  </nav>

  <?php $this->load->view($page) ?>

  <script src="<?=base_url('assets/js/vue.js') ?>"></script>
  <script src="<?=base_url('assets/js/app-vue.js') ?>"></script>
</body>

</html>