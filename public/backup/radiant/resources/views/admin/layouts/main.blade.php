<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Ayt Business') }}</title>

    <!-- Styles -->
    <link href="{{ CSS }}app.css" rel="stylesheet">
    <link href="{{ CSS }}all.min.css" rel="stylesheet">
    <link href="{{ CSS }}common.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset($site_settings['favicon'])}}" type="image/x-icon">
    @yield('header_scripts')

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        @include('admin/include/header')

        <!-- Control Sidebar -->
        @include('admin/include/sidebar')

        <!-- Main Content -->
        <div class="content-wrapper">
            <!-- Control Breadcrumbs -->
            @include('admin/include/breadcrumb')

            <!-- flash-message-blade -->
            @include('admin/include/flash-message')

            <!-- Content -->
            @yield('content')
        </div>

        <!-- Main Footer -->
        @include('admin/include/footer')
    </div>
    <!-- Scripts -->
    <script src="{{ JS }}app.js"></script>
    <script src="{{ JS }}all.min.js"></script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
                $(this).remove();
            });
        }, 5000);
        var path = window.location.href;

        const allLinks = document.querySelectorAll('.nav-item');

        $(allLinks).each(function(index, elem) {

            let has_ul = $(elem).find('.nav-treeview').length;

            if (has_ul) {
                let ul = $(elem).find('ul');
                let links = $(ul).find('.nav-link');

                $(links).each(function(child_index, child_elem) {
                    let child_link = $(child_elem).attr('href');
                    if (child_link === path) {
                        $(elem).find('a:first').addClass('active');
                        $(elem).find('a:first').parent().addClass('menu-is-opening');
                        setTimeout(() => {
                            $(elem).find('a:first').parent().addClass('menu-open');
                        }, 500);
                        $(child_elem).addClass('active');
                    }
                })


            } else {
                let link = $(elem).find('a:first').attr('href');

                if (link === path) {
                    $(elem).find('a:first').addClass('active');
                }
            }
        })
    </script>
    @yield('footer_scripts')
</body>

</html>
