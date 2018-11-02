<!doctype html>
<html>
<head>
    @include ('basics.head')
    @yield ('head')
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- ヘッダー -->
        @include ('basics.header')


        <!-- サイドバー -->
        @include ('basics.sidebar')

        <!-- content -->
        <div class="content-wrapper">
            <!-- フラッシュメッセージ -->
            @include ('modules.message')
            <!-- コンテンツ -->
            @yield ('content')

        </div><!-- end content -->


        <!-- フッター -->
        @include ('basics.footer')

        <!-- サイドバー -->
        @include ('basics.control_sidebar')


    </div><!-- end wrapper -->
    <!-- JS -->
    @include ('basics.script')
    @yield ('script')
</body>
</html>
