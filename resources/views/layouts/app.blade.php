<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    @include('templates.metadata')
    <style>
        .currency{
            text-align: right;
        }
    </style>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            @include('templates.sidebar')
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    @include('templates.navbar')
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                @include('templates.footer')
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    @include('templates.metascript')
    @include('templates.script')
    @stack('script')
    <script>
    $(document).ready(function(){
        var baseUrl = "{{URL('/')}}";
        $('.dataTables_length select').addClass('select2');
        $('.dataTables_length select').removeClass('form-select form-select-sm');
        $('#{{@$table_id}}_filter input').unbind();
        $('#{{@$table_id}}_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.search(this.value).draw();   
            }
        });
        var get = [];
        location.search.replace('?','').split('&').forEach(function(val){
            split = val.split("=",2);
            get[split[0]] = split[1];
        });

        if(window.location.href == "{{URL('/')}}/"){
            var url = window.location.href.substring(0, window.location.href.length - 1);
        }else{
            var url = window.location;
        }
        $('ul li a[href="'+ url +'"]').parent().addClass('active');

        $(document).on('keyup', '.currency', function(event) {
          // skip for arrow keys
          if(event.which >= 37 && event.which <= 40) return;
          //skip non number
          if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault()
          }
          // format number
          $(this).val(function(index, value) {
            return value.replace(/[^-?0-9\,]/g,'').replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          })
        })
    });
    function buttondisable(elm){
        // $(elm).text('Loading...');
        // $(elm).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
        $(elm).addClass('disabled');
        $(elm).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span>Loading...</span>');
    }
    function buttonsmdisable(elm){
        // $(elm).text('Loading...');
        // $(elm).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
        $(elm).addClass('disabled');
        $(elm).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span></span>');
    }
    </script>
</body>

</html>