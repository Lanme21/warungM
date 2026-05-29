<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('/assets/img/favicon.png') }}" />
    <title>Warung Ceria Bahagia</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="{{ asset('/assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">
    <x-navBar-home />
    <main class="mt-0 transition-all duration-200 ease-in-out">
        {{ $slot }}
    </main>
    <footer class="py-12">
        <div class="container">

            <div class="flex flex-wrap -mx-3">
                <div class="w-8/12 max-w-full px-3 mx-auto mt-1 text-center flex-0">
                    <p class="mb-0 text-slate-400">
                        Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        Argon Dashboard 2 by Creative Tim.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    @include('sweetalert::alert')
</body>
<!-- plugin for scrollbar  -->
<script src="{{ asset('/assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
<!-- main script file  -->
<script src="{{ asset('/assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>
@stack('scripts');
{{-- fetch data --}}
<script>
    $(document).ready(function() {
        $('input[autofocus]').on('keypress', function(e) {
            if (e.which == 13) { // Enter key pressed
                e.preventDefault(); // Prevent form submission
                let kodeBarang = $(this).val();
                $.ajax({
                    url: "/fetch-barang",
                    method: 'GET',
                    data: {
                        kode_barang: kodeBarang
                    },
                    success: function(response) {
                        $("#nama_barang").text(response.data.barangs['nama']);
                        $("#kategori_satuan").text(response.data.barangs['kategori'] +
                            " / " + response.data.barangs['satuan']);
                        $("#scan").val("");
                        let bilangan = response.data['harga_jual'];
                        let reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        ribuan = ribuan.join('.').split('').reverse().join('');

                        // Cetak hasil	
                        $("#harga_barang").val(ribuan);
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        console.error(error);
                        $(this).val("");
                    }

                });

                ;
            }

            // Clear the input field
        });
    });
</script>


</html>
