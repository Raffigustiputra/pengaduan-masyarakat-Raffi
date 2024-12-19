@extends('layout.app')

@section('content')
    <div class="min-h-screen flex items-stretch bg-gray-100">
        @include('layout.alert')
        <!-- Left Section -->
        <div class="w-full md:w-1/2 flex flex-col justify-center p-8 bg-white">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di Website Pengaduan Masyarakat</h2>
            <p class="text-gray-600 mb-6">Kami hadir untuk membantu Anda menyampaikan segala bentuk pengaduan atau keluhan
                dengan cepat dan mudah. Mari bergabung dengan kami untuk menciptakan lingkungan yang lebih baik.</p>
            <a href="{{ route('login') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Bergabung
            </a>
        </div>

        <!-- Right Section -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-200">
            <img src="/assets/images/masyarakat.png" alt="Pengaduan" class="object-cover w-full h-full">
        </div>
    </div>
@endsection
