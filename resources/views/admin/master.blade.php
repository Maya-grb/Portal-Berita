<!doctype html>
<html lang="en">
  <!--begin::Head-->
@include("admin.layouts.head")
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      @include('admin.layouts.navbar')
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">@yield('page-title', 'Dashboard')</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb', 'Dashboard')</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            @yield('content')
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <strong>Copyright &copy; 2014-2025&nbsp;<a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong>
        All rights reserved.
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    @include('admin.layouts.script')
    <!--end::Script-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
      Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false });
    </script>
    @endif
    @if(session('error'))
    <script>
      Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
    </script>
    @endif
    @stack('scripts')
  </body>
</html>