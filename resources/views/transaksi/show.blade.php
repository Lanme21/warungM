<x-layouts>
    @push('styles')
        <style>
            /* CSS khusus untuk print */
            @media print {

                /* Sembunyikan semua elemen di body */
                body * {
                    visibility: hidden;
                }

                /* Tampilkan hanya area struk */
                #struk-print-area,
                #struk-print-area * {
                    visibility: visible;
                }

                /* Hilangkan margin, atur posisi ke pojok kiri atas */
                #struk-print-area {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 58mm;
                    /* Sesuaikan dengan ukuran printer Anda (58mm atau 80mm) */
                    padding: 0;
                    margin: 0;
                    display: block !important;
                    font-family: 'Courier New', Courier, monospace;
                    /* Font struk */
                    font-size: 12px;
                    color: black;
                }

                /* Hilangkan header & footer default bawaan browser */
                @page {
                    size: auto;
                    margin: 0mm;
                }
            }
        </style>
    @endpush
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css">
    <script src="https://cdn.datatables.net/2.3.5/js/jquery.dataTables.js"></script>
    <div class="w-full p-0 mx-auto">
        <div class="flex flex-wrap ">
            <div class="w-full max-w-full px-3 shrink-0 ">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 border-b-0 border-solid border-black/12.5 rounded-t-2xl">
                        <div class="flex items-center justify-between ">
                            <p class="mb-0 font-bold dark:text-white/80">Detail Barang</p>
                            <button type="button" id="btn-masukan"
                                class="px-8 py-2 text-sm font-bold text-white transition-all bg-blue-500 rounded-lg shadow-md hover:shadow-xs active:opacity-85">Cetak</button>
                        </div>
                    </div>
                    <div class="flex-auto p-6">
                        <table id="example"
                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500 display">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Kode Barang</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Nama Barang</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Satuan Barang</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Harga Barang</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        jumlah Barang</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Total Bayar</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $transaksi)
                                    <tr>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <h6 class="mb-0 text-sm leading-normal dark:text-white">
                                                {{ $transaksi->barang_kode }}
                                            </h6>
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            {{ $transaksi->barangs->nama }}
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            {{ $transaksi->barangs->satuan }}
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            @rupiah($transaksi->barangs->etalase->harga_jual)
                                        </td>

                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            {{ $transaksi->jumlah }}
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            @rupiah($transaksi->harga)
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>


        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script>
        // Script bawaan DataTables Anda
        new DataTable('#example', {
            scrollCollapse: true,
            scrollY: '50vh'
        });

        // Fungsi untuk memicu print ketika tombol 'Cetak' ditekan
        document.getElementById('btn-masukan').addEventListener('click', function() {
            window.print();
        });
    </script>


    <div id="struk-print-area" class="hidden">
        <div class="struk-container">
            <div class="text-center">
                <h3 style="margin: 0; font-size: 16px;">NAMA TOKO ANDA</h3>
                <p style="margin: 0;">Jl. Alamat Toko No. 123</p>
                <p style="margin: 0;">Telp: 08123456789</p>
                <p>--------------------------------</p>
            </div>

            <table style="width: 100%; border-collapse: collapse;">
                @php $totalHarga = 0; @endphp
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td colspan="3" style="padding-bottom: 2px;">{{ $transaksi->barangs->nama }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">{{ $transaksi->jumlah }} {{ $transaksi->barangs->satuan }}</td>
                        <td style="width: 35%;">x @rupiah($transaksi->barangs->etalase->harga_jual)</td>
                        <td style="width: 35%; text-align: right;">@rupiah($transaksi->harga)</td>
                    </tr>
                    @php $totalHarga += $transaksi->harga; @endphp
                @endforeach
            </table>

            <div class="text-center" style="margin-top: 10px;">
                <p>--------------------------------</p>
                <p style="margin: 0; font-size: 14px;"><strong>TOTAL: @rupiah($totalHarga)</strong></p>
                <p>--------------------------------</p>
                <p style="margin-top: 10px;">Terima Kasih</p>
                <p>Barang yang sudah dibeli<br>tidak dapat ditukar</p>
            </div>
        </div>
    </div>
</x-layouts>
