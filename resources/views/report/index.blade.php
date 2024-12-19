@extends('layout.app')

@section('content')
    <div class="bg-gradient-to-br from-yellow-100 via-orange-100 to-green-100 min-h-screen p-6">
        @include('layout.alert')
        <!-- Main Container -->
        <div class="max-w-screen-xl mx-auto p-4 md:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Search Bar -->
                    <form action="" method="GET"
                        class="flex flex-wrap md:flex-nowrap items-center gap-3 animate-fadeInUp">
                        <select name="province" id="province"
                            class="w-full md:w-auto flex-grow p-2 text-sm text-gray-900 border border-gray-400 rounded-lg focus:ring-orange-500 focus:border-orange-500 transition duration-300">
                            <option selected>Pilih Provinsi</option>
                        </select>
                        <a href="{{ route('report') }}"
                            class="w-full md:w-auto flex items-center justify-center px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-300 transition duration-300">
                            <i class="fas fa-times mr-2"></i>
                        </a>
                        <button type="submit"
                            class="w-full md:w-auto flex items-center justify-center px-4 py-2 text-white bg-orange-600 hover:bg-orange-700 rounded-lg focus:outline-none focus:ring-4 focus:ring-orange-300 transition duration-300">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </form>

                    <!-- Reports Section -->
                    <div class="space-y-4 my-6 max-h-[calc(85vh-70px)] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse ($reports as $index => $report)
                            <div class="relative flex bg-white rounded-lg shadow-lg p-4 items-center report-card animate-fadeInUp"
                                style="animation-delay: {{ $index * 0.1 }}s;" data-report-id="{{ $report->id }}">
                                <img src="{{ asset('storage/reports/' . $report->image) }}" alt="{{ $report->description }}"
                                    class="w-36 h-24 rounded object-cover transition duration-300 transform hover:scale-105">
                                <div class="ml-4 flex-grow">
                                    <h5
                                        class="font-semibold text-lg text-gray-900 hover:text-orange-600 transition duration-300">
                                        <a href="{{ route('report_comment', $report->id) }}" class="hover:underline">
                                            {{ Str::limit($report->description, 50) }}
                                        </a>
                                    </h5>
                                    <div class="text-sm text-gray-600 space-x-3 mt-2">
                                        <span class="inline-flex items-center"><i class="fas fa-eye mr-1"></i><span
                                                class="viewers-count">{{ $report->viewers }}</span></span>
                                        <span class="inline-flex items-center"><i class="fas fa-comments mr-1"></i><span
                                                class="comments-count">{{ $report->Comment->count() }}</span></span>
                                        <span class="inline-flex items-center"><i
                                                class="fas fa-heart mr-1 love-icon cursor-pointer text-red-500"></i><span
                                                class="voting-count"></span></span>
                                        <span class="inline-flex items-center">{{ $report->user->email ?? 'Anonim' }}</span>
                                        <span
                                            class="inline-flex items-center"></i>{{ $report->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <i
                                    class="fas fa-heart absolute top-2 right-2 text-xl love-icon cursor-pointer text-red-500 hover:text-red-600 transition duration-300 transform hover:scale-110"></i>
                            </div>
                        @empty
                            <div class="text-center p-6 bg-gray-100 rounded-lg shadow-md animate-fadeInUp">
                                <p class="text-gray-600 font-semibold text-lg">Tidak ada laporan yang tersedia.</p>
                                <button onclick="location.reload()"
                                    class="mt-4 px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition duration-300">
                                    <i class="fas fa-sync-alt mr-2"></i>Muat Ulang
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Section -->
                <div class="lg:fixed lg:top-1/2 lg:right-4 lg:transform lg:-translate-y-1/2 w-full max-w-md animate-fadeInUp"
                    style="animation-delay: 0.3s;">
                    <div class="bg-white p-6 rounded-lg shadow-lg transition duration-300 hover:shadow-xl">
                        <h3 class="text-green-600 text-xl font-bold mb-4">Informasi Pembuatan Pengaduan</h3>
                        <ol class="list-decimal text-gray-700 space-y-2 pl-4">
                            <li class="transition duration-300 hover:text-orange-600">Pengaduan bisa dibuat hanya jika Anda
                                telah membuat akun sebelumnya.</li>
                            <li class="transition duration-300 hover:text-orange-600">Keseluruhan data pada pengaduan
                                bernilai BENAR dan DAPAT DIPERTANGGUNG JAWABKAN.</li>
                            <li class="transition duration-300 hover:text-orange-600">Seluruh bagian data perlu diisi.</li>
                            <li class="transition duration-300 hover:text-orange-600">Periksa tanggapan kami pada Dashboard
                                setelah Anda Login.</li>
                            <li class="transition duration-300 hover:text-orange-600">Pembuatan pengaduan dapat dilakukan
                                pada halaman berikut:
                                <a href="{{ route('report_create') }}"
                                    class="text-green-600 underline hover:text-green-800 transition duration-300">Ikuti
                                    Tautan</a>.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const apiURL =
                "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json";

            $.ajax({
                url: apiURL,
                method: "GET",
                success: function(response) {
                    console.log("Data berhasil diambil:", response); // Debug data respons
                    if (Array.isArray(response)) {
                        response.forEach((province) => {
                            $("#province").append(
                                `<option value="${province.name}">${province.name}</option>`
                            );
                        });
                    } else {
                        console.error("Data tidak valid:", response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Gagal memuat data:", error);
                },
            });
        });
    </script>
@endsection
