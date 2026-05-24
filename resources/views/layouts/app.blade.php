<!doctype html>
<html lang="th" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="{{ asset('/images/logo.png') }}" type="image/x-icon">
  <title>@yield('title', 'Yasothon One Province One Data : YSOPOD')</title>

  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  {{-- DataTables --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

  {{-- SweetAlert2 --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- Custom Styles --}}
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');

    :root{
      --green:#18a573;
      --green-2:#21c08b;
      --blue:#0d6efd;
      --bg-1:#e9fbf2;
      --glass-bg:rgba(255,255,255,.7);
      --glass-bd:rgba(33, 192, 139, .35);
      --shadow:0 10px 30px rgba(24,165,115,.15);
      --radius:22px;
    }
    body{
      font-family: 'Kanit', 'Inter', sans-serif;
      font-size: 14px;
      min-height:100vh;
      background:
        radial-gradient(1200px 800px at 10% -10%, rgba(33,192,139,.18), transparent 60%),
        radial-gradient(1000px 600px at 110% 10%, rgba(13,110,253,.14), transparent 60%),
        linear-gradient(135deg, #f6fffb 0%, var(--bg-1) 40%, #ffffff 100%);
      animation: floatBg 24s ease-in-out infinite alternate;
      background-attachment: fixed;
    }
    /* ปรับขนาด heading ให้เหมาะกับ Kanit font */
    h1 { font-size: 1.75rem; }
    h2 { font-size: 1.45rem; }
    h3 { font-size: 1.25rem; }
    h4 { font-size: 1.1rem;  }
    h5 { font-size: 0.95rem; }
    h6 { font-size: 0.85rem; }

    /* ปรับตารางให้ compact สวยงาม */
    .table td, .table th {
      font-size: 0.8rem;
      padding: 0.28rem 0.5rem;
      vertical-align: middle;
    }
    .table thead th, .table thead td {
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.01em;
    }

    @keyframes floatBg{0%{background-position:0 0}100%{background-position:5% -3%}}
    .brand-title,h1,h2,h3,h4,.nav-link,.table thead th{color:var(--blue);}
    .glass{background:var(--glass-bg);border:1px solid var(--glass-bd);backdrop-filter:blur(10px);border-radius:var(--radius);box-shadow:var(--shadow);}
    .text-green{color:var(--green)!important;}
    
  </style>

  @stack('styles')
</head>

<body>
  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg bg-white bg-opacity-75 border-bottom sticky-top glass" style="border-radius:0">
      <div class="container-fluid">
          <a class="navbar-brand d-flex align-items-center text-primary brand-title fw-bold" href="{{ url('web/') }}">
              <i class="fa-solid fa-bed-pulse text-danger fs-5 me-2"></i> IPD
          </a>

          <a class="navbar-brand d-flex align-items-center text-primary brand-title fw-bold" href="{{ url('web/opd') }}">
              <i class="bi bi-person-vcard text-green me-2"></i> OPD
          </a>

          <a class="navbar-brand d-flex align-items-center text-primary brand-title fw-bold" href="{{ url('web/refer') }}">
              <i class="fa-solid fa-truck-medical text-primary me-2"></i> Refer
          </a>

          <a class="navbar-brand d-flex align-items-center text-primary brand-title fw-bold" href="{{ url('web/operation') }}">
              <i class="fa-solid fa-kit-medical text-danger me-2"></i> ผ่าตัด
          </a>



          {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav">
              <span class="navbar-toggler-icon"></span>
          </button> --}}

          <div class="collapse navbar-collapse" id="topnav">
              {{-- <ul class="navbar-nav ms-auto">
                  @auth
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle text-primary" href="#" id="userDropdown" role="button"
                             data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                          <ul class="dropdown-menu dropdown-menu-end">
                              <li>
                                  <form action="{{ route('logout') }}" method="POST">@csrf
                                      <button type="submit" class="dropdown-item text-primary">Logout</button>
                                  </form>
                              </li>
                          </ul>
                      </li>
                  @else
                      <li class="nav-item">
                          <a class="nav-link text-primary" href="#" data-bs-toggle="modal"
                             data-bs-target="#loginModal"><strong>Login</strong></a>
                      </li>
                  @endauth
              </ul> --}}
          </div>
      </div>
  </nav>

  {{-- MAIN CONTENT --}}
  <main class="py-4">
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="py-4">
    <div class="container text-center text-secondary small">
      © {{ now()->year }} Yasothon One Province One Data : YSOPOD
    </div>
  </footer>

  {{-- Login Modal --}}
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">เข้าสู่ระบบ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">อีเมล</label>
                  <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">รหัสผ่าน</label>
                  <input type="password" name="password" class="form-control" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Scripts --}}
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables core -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Buttons + Export -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- JSZip (required for Excel export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  @stack('scripts')
</body>
</html>
