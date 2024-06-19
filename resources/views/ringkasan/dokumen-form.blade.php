<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('template2/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('template2/assets/img/favicon.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    D-T-O | DOCUMENT-TO-TEXT
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="{{ asset('template2/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('template2/assets/css/paper-kit.css') }}" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ asset('template2/assets/demo/demo.css') }}" rel="stylesheet" />

  <!-- Style for centering the form and dark background -->
  <style>
    body {
      background-color: #000;
      color: #fff;
    }

    .navbar {
      background-color: rgba(0, 0, 0, 0.7) !important;
    }

    .centered-form {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .centered-form .form-container {
      max-width: 500px;
      width: 100%;
      padding: 20px;
      background-color: rgba(2, 2, 2, 0.9);
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .usage-instructions {
      text-align: center;
      margin-top: 40px;
      padding: 20px;
      background-color: rgba(2, 2, 2, 0.9);
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .usage-section {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .usage-points,
    .usage-download {
      flex: 1;
      margin: 10px;
      min-width: 250px;
    }

    .usage-points ul {
      list-style-type: none;
      padding: 0;
    }

    .usage-points li {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }

    .usage-points li::before {
      content: "✔";
      color: green;
      margin-right: 10px;
      font-size: 1.2em;
    }

    .usage-download {
      text-align: center;
    }

    .usage-download a {
      color: #fff;
      text-decoration: none;
      border: 2px solid #fff;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 1.1em;
      transition: background-color 0.3s, color 0.3s;
    }

    .usage-download a:hover {
      background-color: #fff;
      color: #000;
    }
  </style>
</head>

<body class="index-page sidebar-collapse">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top navbar-transparent " color-on-scroll="300">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="https://demos.creative-tim.com/paper-kit/index.html" rel="tooltip" title="Coded by Creative Tim" data-placement="bottom" target="_blank">
          SUMMARY LEAGUE INDONESIAN
        </a>
        <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="/ringkasan" class="nav-link"><i class="fa fa-text-height" aria-hidden="true"></i> TEXT-TO-TEXT</a>
          </li>
          <li class="nav-item">
            <a href="/dokumen-ringkasan" class="nav-link"><i class="fa fa-file-text" aria-hidden="true"></i> DOCUMENT-TO-TEXT</a>
          </li>
          <li class="nav-item">
            <a href="/upload-form" class="nav-link"><i class="fa fa-file-image-o" aria-hidden="true"></i> IMAGE-TO-TEXT</a>
          </li>
          <li class="nav-item">
            <a href="/form-url" class="nav-link"><i class="fa fa-external-link" aria-hidden="true"></i> URL-TO-TEXT</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container centered-form">
    <div class="form-container">
      <center>
        <h1 style="font-size: 30px">SUMMARY DOCUMENT-TO-TEXT</h1>
      </center>
      <form method="post" action="{{ route('dokumen.ringkasan.proses') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="dokumen">Unggah Dokumen (TXT, DOC, DOCX, atau PDF):</label>
          <input type="file" class="form-control" name="dokumen">
          @error('dokumen')
          <div class="error-message">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-outline-success">Ringkas Dokumen</button>
      </form>
    </div>
  </div>

  <div class="container">
    <div class="usage-instructions">
      <h4><b>CARA PENGGUNAAN DOCUMENT TO TEXT</b></h4>
      <br>
      <div class="usage-section">
        <div class="usage-points">
          <ul style="text-align: left">
            <li>Unggah dokumen yang ingin diringkas pada kotak yang tersedia.</li>
            <li>Klik tombol "Ringkas Dokumen" untuk mendapatkan ringkasan dokumen.</li>
            <li>Pastikan dokumen yang diunggah dalam format yang didukung (TXT, DOC, DOCX, atau PDF).</li>
          </ul>
        </div>
        <div class="usage-download">
          <a href="e-book/CARA-PENGGUNAAN-FITUR-DOKUMEN-TO-TEKS.pdf" download="Cara Penggunaan">Unduh e-book penggunaan (PDF)</a>
        </div>
      </div>
    </div>
  </div>

  
  <footer class="footer footer-black footer-white">
    <div class="container">
      <div class="row">
        <nav class="footer-nav">
          <ul>
            <li>
              <a href="/" target="_blank">HOME</a>
            </li>
          </ul>
        </nav>
        <div class="credits ml-auto">
          <span class="copyright">
            ©
            <script>
              document.write(new Date().getFullYear())
            </script>, web create <i class="fa fa-heart heart"></i> by Siti Nur Khodijah
          </span>
        </div>
      </div>
    </div>
  </footer>

  <!-- Core JS Files -->
  <script src="{{ asset('template2/assets/js/core/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('template2/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('template2/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
  <!-- Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="{{ asset('template2/assets/js/plugins/bootstrap-switch.js') }}"></script>
  <!-- Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="{{ asset('template2/assets/js/plugins/nouislider.min.js') }}" type="text/javascript"></script>
  <!-- Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
  <script src="{{ asset('template2/assets/js/plugins/moment.min.js') }}"></script>
  <script src="{{ asset('template2/assets/js/plugins/bootstrap-datepicker.js') }}" type="text/javascript"></script>
  <!-- Control Center for Paper Kit: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('template2/assets/js/paper-kit.js?v=2.2.0') }}" type="text/javascript"></script>
  <!-- Google Maps Plugin -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script>
    $(document).ready(function() {
      if ($("#datetimepicker").length != 0) {
        $('#datetimepicker').datetimepicker({
          icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
          }
        });
      }

      function scrollToDownload() {
        if ($('.section-download').length != 0) {
          $("html, body").animate({
            scrollTop: $('.section-download').offset().top
          }, 1000);
        }
      }
    });
  </script>
</body>

</html>
