@if (session('exito'))
    <script language="javascript">
        $(document).ready(function(){
            swal(
                    'Correcto',
                    '{{session('exito')}}',
                    'success'
            )
        });
    </script>
@endif
@if (session('fallo'))
    <script language="javascript">
        $(document).ready(function(){
            swal(
                    'Oops...',
                    '{{session('fallo')}}',
                    'error'
            )
        });
    </script>
@endif
@if (session('info'))
    <script language="javascript">
        $(document).ready(function(){
            swal(
                    'Información',
                    '{{session('info')}}',
            )
        });
    </script>
@endif