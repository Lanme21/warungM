<x-layouts>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css">
    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-0">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <form action="{{ route('belanja.store') }}" method="POST">
                        @csrf

                        <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                            <div class="flex items-center">
                                <p class="mb-0 font-bold dark:text-white/80">Tambah Belanja</p>
                                <button type="submit"
                                    class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Simpan</button>
                            </div>
                        </div>
                        <div class="flex-auto p-6">
                            <p class="leading-normal uppercase dark:text-white dark:opacity-60 text-sm">Memasukan ke
                                daftar belanja</p>
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <label for="kode_barang"
                                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">
                                                Kode Barang
                                            </label>
                                            <button type="button" id="btn-scan"
                                                class="inline-block px-3 py-1 text-xs font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-700 transition-all">
                                                📷 Scan Barcode
                                            </button>
                                        </div>

                                        <div id="reader" class="w-full mb-2" style="display: none;"></div>

                                        <input type="text" name="kode_barang" id="kode_barang"
                                            value="{{ old('kode_barang') }}" placeholder="Scan barcode yang tersedia"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                            list="listlist" autocomplete="off" />

                                        <datalist id="listlist">
                                            @foreach ($barang as $item)
                                                <option value="{{ $item->kode }}">
                                                    {{ $item->kode }} => {{ $item->nama }} - {{ $item->satuan }}
                                                </option>
                                            @endforeach
                                        </datalist>

                                        @error('kode_barang')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="nama"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama
                                            Item</label>
                                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                            placeholder="Masukkan nama item"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('nama')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="satuan"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Satuan</label>
                                        <input type="text" name="satuan" id="satuan" value="{{ old('satuan') }}"
                                            placeholder="Masukkan satuan item"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('satuan')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="kategori"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Kategori</label>
                                        <input type="text" name="kategori" id="kategori"
                                            value="{{ old('kategori') }}" placeholder="Masukkan kategori item"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('kategori')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="harga_beli"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Harga
                                            Beli</label>
                                        <input type="number" name="harga_beli" value="{{ old('harga_beli') }}"
                                            step="500" placeholder="Masukkan harga beli"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('harga_beli')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="harga_jual"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Harga
                                            Jual</label>
                                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}"
                                            step="500" placeholder="Masukkan harga jual"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('harga_jual')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="jumlah"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Jumlah</label>
                                        <input type="number" name="jumlah" value="{{ old('jumlah') }}"
                                            placeholder="Masukkan jumlah item"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('jumlah')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-6 shrink-0 md:w-4/12 md:flex-0 md:mt-0">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <img class="w-full rounded-t-2xl" src="{{ asset('assets/img/background-baru.png') }}"
                        alt="profile cover image">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const btnScan = document.getElementById('btn-scan');
                const readerDiv = document.getElementById('reader');
                const inputKodeBarang = document.getElementById('kode_barang');

                // Element target autofill
                const inputNama = document.getElementById('nama');
                const inputSatuan = document.getElementById('satuan');
                const inputKategori = document.getElementById('kategori');

                // Mengonversi data koleksi Eloquent Laravel menjadi Array Object JavaScript
                const listBarang = @json($barang);

                // Fungsi untuk melakukan pencarian dan pengisian otomatis
                function jalankanAutofill() {
                    const kodeTerpilih = inputKodeBarang.value;

                    // Cari item barang yang kodenya cocok
                    const barangKetemu = listBarang.find(item => item.kode == kodeTerpilih);

                    if (barangKetemu) {
                        inputNama.value = barangKetemu.nama ?? '';
                        inputSatuan.value = barangKetemu.satuan ?? '';
                        inputKategori.value = barangKetemu.kategori ??
                            ''; // Pastikan 'kategori' ada pada properti model $barang Anda
                    }
                }

                // Dengarkan event 'input' (ketika mengetik/memilih dari datalist) 
                // dan event 'change' (ketika dipicu oleh scanner)
                inputKodeBarang.addEventListener('input', jalankanAutofill);
                inputKodeBarang.addEventListener('change', jalankanAutofill);

                let html5QrcodeScanner = null;

                btnScan.addEventListener('click', function() {
                    readerDiv.style.display = 'block';

                    if (html5QrcodeScanner) return;

                    html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            },
                            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                        },
                        false
                    );

                    function onScanSuccess(decodedText, decodedResult) {
                        inputKodeBarang.value = decodedText;

                        html5QrcodeScanner.clear().then(() => {
                            readerDiv.style.display = 'none';
                            html5QrcodeScanner = null;

                            // Memicu event change agar fungsi jalankanAutofill() terpanggil otomatis
                            inputKodeBarang.dispatchEvent(new Event('change'));

                            document.querySelector('input[name="harga_beli"]').focus();
                        }).catch(error => {
                            console.error("Gagal menghentikan scanner.", error);
                        });
                    }

                    function onScanFailure(error) {}

                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                });
            });
        </script>
    @endpush
</x-layouts>
