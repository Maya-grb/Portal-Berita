<!--begin::Third Party Plugin(OverlayScrollbars)-->
<script 
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" 
    crossorigin="anonymous">
</script>
<!--end::Third Party Plugin(OverlayScrollbars)-->

<!--begin::Required Plugin(Popper.js for Bootstrap 5)-->
<script 
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
    crossorigin="anonymous">
</script>
<!--end::Required Plugin(Popper.js for Bootstrap 5)-->

<!--begin::Required Plugin(Bootstrap 5)-->
<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" 
    crossorigin="anonymous">
</script>
<!--end::Required Plugin(Bootstrap 5)-->

<!--begin::Required Plugin(AdminLTE)-->
<script src="{{ asset('assets/js/adminlte.js') }}"></script>
<!--end::Required Plugin(AdminLTE)-->

<!--begin::jQuery (Required for Summernote)-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--end::jQuery-->

<!--begin::Summernote-->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-id-ID.min.js"></script>
<!--end::Summernote-->

<!--begin::OverlayScrollbars Configure-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarWrapper = document.querySelector('.sidebar-wrapper');
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined' && OverlayScrollbarsGlobal.OverlayScrollbars) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: 'os-theme-light',
                    autoHide: 'leave',
                    clickScroll: true,
                },
            });
        }
    });
</script>
<!--end::OverlayScrollbars Configure-->

<!--begin::Custom Scripts-->
@stack('scripts')
<!--end::Custom Scripts-->