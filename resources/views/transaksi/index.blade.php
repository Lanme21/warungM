<x-layouts>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css">
    <script src="https://cdn.datatables.net/2.3.5/js/jquery.dataTables.js"></script>
    <div class="w-full p-0 mx-auto">
        <div class="flex flex-wrap ">
            <div class="w-full max-w-full px-3 shrink-0 ">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                        <div class="flex items-center">
                            <p class="mb-0 font-bold dark:text-white/80">Daftar Transaksi</p>
                            <a href="{{ route('barang.create') }}"
                                class="inline-block px-8 py-2 ml-auto text-xs font-bold text-center text-blue-500 uppercase align-middle transition-all ease-in bg-transparent border border-blue-500 border-solid rounded-lg shadow-none cursor-pointer active:opacity-85 leading-pro tracking-tight-rem bg-150 bg-x-25 hover:scale-102 active:shadow-xs hover:text-blue-500 hover:opacity-75 hover:shadow-none active:scale-100 active:border-blue-500 active:bg-blue-500 active:text-white hover:active:border-blue-500 hover:active:bg-transparent hover:active:text-blue-500 hover:active:opacity-75">Tambah</a>



                        </div>
                    </div>
                    <div class="flex-auto p-6">
                        <table id="example"
                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500 display">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        No Faktur</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Jumlah Item</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Total Belanja</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-sm border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Status Pembayaran</th>
                                    <th
                                        class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $transaksi)
                                    <tr>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <h6 class="mb-0 text-sm leading-normal dark:text-white">
                                                {{ $transaksi->faktur }}</h6>
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            <p>{{ $transaksi->tanggal_faktur }}</p>
                                        </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            {{ $transaksi->jumlah_Item }}</td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            @rupiah($transaksi->total_harga) </td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                            {{ $transaksi->status_transaksi }}</td>
                                        <td
                                            class="p-2 align-middle bg-transparent border-b-0 whitespace-nowrap shadow-transparent">
                                            <a href="{{ route('transaksi.show', $transaksi->faktur) }}"
                                                class="text-sm font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">Detail</a>
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
        new DataTable('#example', {
            scrollCollapse: true,
            scrollY: '50vh'
        });
    </script>


</x-layouts>
