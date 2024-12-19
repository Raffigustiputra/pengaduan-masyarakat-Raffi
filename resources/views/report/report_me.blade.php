@extends('layout.app')

@section('content')
    <main class="container mx-auto py-8 px-4 max-w-4xl">
        @include('layout.alert')
        <h1 class="text-3xl md:text-4xl font-bold text-center mb-8 text-gray-800 animate-fadeIn">Monitoring Pengaduan
        </h1>
        <div class="space-y-6">
            @forelse ($reports as $index => $report)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl animate-fadeIn"
                    style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="bg-green-600 text-white px-6 py-4 flex justify-between items-center cursor-pointer toggle-content"
                        data-target="content-{{ $index }}">
                        <h2 class="text-lg font-bold">
                            Pengaduan
                            {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('j F Y') }}
                        </h2>
                        <i class="fas fa-chevron-down toggle-icon transition-transform duration-300"></i>
                    </div>

                    <div class="report-content hidden opacity-0 transition-all duration-300 ease-in-out"
                        id="content-{{ $index }}">
                        <div class="px-6 py-4">
                            <ul class="flex justify-between items-center mb-4 border-b border-gray-200">
                                <li class="tab-button px-4 py-2 cursor-pointer text-green-600 hover:text-green-800 font-medium transition duration-200"
                                    data-tab="data-{{ $index }}">Data</li>
                                <li class="tab-button px-4 py-2 cursor-pointer text-green-600 hover:text-green-800 font-medium transition duration-200"
                                    data-tab="gambar-{{ $index }}">Gambar</li>
                                <li class="tab-button px-4 py-2 cursor-pointer text-green-600 hover:text-green-800 font-medium transition duration-200"
                                    data-tab="status-{{ $index }}">Status</li>
                            </ul>

                            <div id="data-{{ $index }}" class="tab-content mb-4 hidden">
                                <h3 class="text-green-800 font-semibold text-lg mb-2">Data Pengaduan</h3>
                                <ul class="text-gray-600 space-y-2">
                                    <li><span class="font-medium">Tipe:</span> {{ $report->type }}</li>
                                    <li><span class="font-medium">Lokasi:</span> {{ $report->village }},
                                        {{ $report->subdistrict }}, {{ $report->regency }}, {{ $report->province }}
                                    </li>
                                    <li class="break-words"><span class="font-medium">Deskripsi:</span>
                                        {{ $report->description }}</li>
                                </ul>
                            </div>

                            <div id="gambar-{{ $index }}" class="tab-content mb-4 hidden">
                                <h3 class="text-green-800 font-semibold text-lg mb-2">Gambar Pengaduan</h3>
                                <div class="flex justify-center">
                                    <img src="{{ asset('storage/reports/' . $report->image) }}"
                                        alt="Gambar Pengaduan"
                                        class="rounded-md shadow-md w-full max-w-md h-60 object-cover transition duration-300 transform hover:scale-105">
                                </div>
                            </div>

                            <div id="status-{{ $index }}" class="tab-content mb-4 hidden">
                                <h3 class="text-green-800 font-semibold text-lg mb-2">Status Pengaduan</h3>
                                @if ($report->response == null)
                                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                                        <p class="font-bold">Belum Direspon</p>
                                        <p>Pengaduan belum direspon oleh petugas.</p>
                                    </div>
                                    <button
                                        class="btn btn-danger px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none transition duration-200"
                                        onclick="openModalDelete('{{ $report->id }}', '{{ $report->created_at->locale('id')->translatedFormat('d F Y') }}')">
                                        <i class="fas fa-trash-alt mr-2"></i> HAPUS
                                    </button>
                                @else
                                    @php
                                        $histories = $report->Response->Progres?->histories
                                            ? json_decode($report->Response->Progres->histories)
                                            : [];
                                        $totalSteps = count($histories);
                                        $completedSteps = $totalSteps;
                                    @endphp
                                    <div class="space-y-4">
                                        @foreach ($histories as $index => $history)
                                            <div class="flex items-center">
                                                <div class="flex items-center relative">
                                                    <div
                                                        class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 @if ($index == $completedSteps - 1) border-green-600 bg-green-600 @else border-green-300 @endif">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%"
                                                            height="100%" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-check-circle @if ($index == $completedSteps - 1) text-white @else text-green-300 @endif">
                                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                        </svg>
                                                    </div>
                                                    @if ($index < $totalSteps - 1)
                                                        <div
                                                            class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-green-600">
                                                            Step {{ $index + 1 }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div
                                                    class="flex-auto border-t-2 transition duration-500 ease-in-out @if ($index < $completedSteps - 1) border-green-600 @else border-gray-300 @endif">
                                                </div>
                                            </div>
                                            <div class="ml-4 mb-6">
                                                <p class="text-gray-600">{{ $history->description }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($history->created_at)->locale('id')->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-lg p-8 text-center animate-fadeIn">
                    <p class="text-xl font-semibold text-gray-800 mb-4">
                        Belum ada pengaduan yang dibuat.
                    </p>
                    <a href="{{ route('report_create') }}"
                        class="inline-block bg-green-500 text-white px-6 py-3 rounded-md shadow hover:bg-green-600 transition duration-300 font-medium">
                        Buat Pengaduan Baru
                    </a>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle content
            document.querySelectorAll(".toggle-content").forEach((header) => {
                header.addEventListener("click", () => {
                    const targetId = header.getAttribute("data-target");
                    const targetContent = document.getElementById(targetId);
                    const toggleIcon = header.querySelector(".toggle-icon");

                    if (targetContent.classList.contains("hidden")) {
                        targetContent.classList.remove("hidden", "opacity-0");
                        targetContent.classList.add("opacity-100");
                        toggleIcon.classList.add("rotate-180");
                    } else {
                        targetContent.classList.remove("opacity-100");
                        targetContent.classList.add("opacity-0");
                        setTimeout(() => {
                            targetContent.classList.add("hidden");
                        }, 300);
                        toggleIcon.classList.remove("rotate-180");
                    }
                });
            });

            // Tab functionality
            document.querySelectorAll(".bg-white").forEach((container) => {
                const tabs = container.querySelectorAll(".tab-button");
                const contents = container.querySelectorAll(".tab-content");

                contents[0]?.classList.remove("hidden");
                tabs[0]?.classList.add("text-green-800", "border-b-2", "border-green-500");

                tabs.forEach((tab) => {
                    tab.addEventListener("click", () => {
                        const tabName = tab.getAttribute("data-tab");

                        tabs.forEach(t => t.classList.remove("text-green-800", "border-b-2",
                            "border-green-500"));
                        tab.classList.add("text-green-800", "border-b-2",
                            "border-green-500");

                        contents.forEach((content) => {
                            content.classList.add("hidden");
                        });

                        container.querySelector(`#${tabName}`).classList.remove("hidden");
                    });
                });
            });
        });

        function openModalDelete(id, created_at) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: `Pengaduan yang dibuat pada ${created_at} akan dihapus.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/report/${id}`;
                }
            });
        }
    </script>
@endsection
