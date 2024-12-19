@extends('layout.app')

@section('content')
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        @include('layout.alert')
        <h3 class="text-2xl font-bold text-gray-800">
            Pengaduan
            {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('j F Y') }}
            <span
                class="px-4 py-2 rounded-full text-white text-sm font-semibold
        @if ($report->type === 'KEJAHATAN') bg-red-500 
        @elseif($report->type === 'PEMBANGUNAN') bg-blue-500 
        @elseif($report->type === 'SOSIAL') bg-green-500 
        @else bg-gray-400 @endif">
                {{ $report->type }}
            </span>
        </h3>


        <!-- Gambar Laporan -->
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex-1 flex justify-center items-center">
                <img src="{{ asset('storage/reports/' . $report->image) }}" alt="Gambar Laporan"
                    class="rounded-lg shadow-md w-full max-w-full max-h-80 object-contain">
            </div>
        </div>

        <!-- Deskripsi Laporan -->
        <div class="flex-1">

            <h2 class="text-lg font-semibold text-gray-700 mb-4">Teks yang Dilaporkan</h2>
            <p class="mb-6 border-l-4 border-blue-500 pl-4 text-gray-600 italic break-words overflow-auto max-w-full">
                {{ $report->description }}</p>
        </div>

        <!-- Lokasi -->
        <div class="bg-gray-100 p-4 rounded-lg mb-6 transition duration-300 hover:bg-gray-200">
            <h4 class="font-semibold text-gray-700 mb-2">Lokasi:</h4>
            <p class="text-gray-600">{{ $report->village }}, {{ $report->subdistrict }},
                {{ $report->regency }}, {{ $report->province }}</p>
        </div>




        <!-- Komentar dengan Scroll -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Komentar</h3>
            <div class="bg-gray-100 p-4 rounded-lg max-h-72 overflow-y-auto">
                @forelse ($comments as $comment)
                    <div class="bg-white p-3 rounded-lg mb-4 shadow-sm flex">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex justify-center items-center text-white mr-4">
                            {{ strtoupper(substr($comment->User->email, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-gray-700">{{ $comment->comment }}</p>
                            <span class="text-sm text-gray-500">
                                - {{ $comment->User->email }} | {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada komentar.</p>
                @endforelse
            </div>
        </div>

        <!-- Form Komentar -->
        <form action="{{ route('comment_store', $report->id) }}" method="POST" class="space-y-6 mt-8">
            @csrf
            <input type="hidden" name="report_id" value="{{ $report->id }}">
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700">Tulis Komentar Anda</label>
                <textarea id="comment" name="comment"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    rows="4" required></textarea>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md shadow-md transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                Kirim Komentar
            </button>
        </form>
    </div>
@endsection
