@extends('layout.app')

@section('content')

    <div class="container mx-auto mt-5 px-4">
        <h1 class="text-center text-3xl font-semibold">Form Create Data</h1>
        @include('layout.alert')

        <form id="createForm" method="POST" action="{{ route('report_store') }}" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @include('layout.alert')

            <!-- Province -->
            <div class="mb-4">
                <label for="province" class="block text-sm font-medium text-gray-700">Pilih Provinsi</label>
                <select id="province" name="province"
                    class="form-select w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" selected disabled>-- Pilih Provinsi --</option>
                </select>
            </div>

            <!-- Hidden inputs for names -->
            <input type="hidden" id="provinceName" name="province_name">
            <input type="hidden" id="regencyName" name="regency_name">
            <input type="hidden" id="subdistrictName" name="subdistrict_name">
            <input type="hidden" id="villageName" name="village_name">

            <!-- Regency -->
            <div class="mb-4" id="regencyWrapper" style="display: none;">
                <label for="regency" class="block text-sm font-medium text-gray-700">Pilih Kabupaten/Kota</label>
                <select id="regency" name="regency"
                    class="form-select w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" selected disabled>-- Pilih Kabupaten/Kota --</option>
                </select>
            </div>

            <!-- Subdistrict -->
            <div class="mb-4" id="subdistrictWrapper" style="display: none;">
                <label for="subdistrict" class="block text-sm font-medium text-gray-700">Pilih Kecamatan</label>
                <select id="subdistrict" name="subdistrict"
                    class="form-select w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" selected disabled>-- Pilih Kecamatan --</option>
                </select>
            </div>

            <!-- Village -->
            <div class="mb-4" id="villageWrapper" style="display: none;">
                <label for="village" class="block text-sm font-medium text-gray-700">Pilih Desa/Kelurahan</label>
                <select id="village" name="village"
                    class="form-select w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" selected disabled>-- Pilih Desa/Kelurahan --</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Pilih Kejahatan</label>
                <select id="type" name="type"
                    class="form-select w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" selected disabled>-- Pilih Kejahatan --</option>
                    <option value="KEJAHATAN">Kejahatan</option>
                    <option value="PEMBANGUNAN">Pembangunan</option>
                    <option value="SOSIAL">Sosial</option>
                </select>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description"
                    class="form-control w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    rows="4" required></textarea>
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Unggah Gambar (opsional)</label>
                <input type="file" id="image" name="image"
                    class="w-full p-2 border border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    accept=".jpg, .jpeg, .png, .gif">
                <small class="text-gray-500">Format yang diterima: JPG, JPEG, PNG, GIF.</small>
            </div>

            <div class="mb-4">
                <div class="flex items-center">
                    <input id="konfirmasi" name="konfirmasi" type="checkbox"
                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition duration-200"
                        {{ old('konfirmasi') ? 'checked' : '' }}>
                    <label for="konfirmasi" class="ml-2 block text-sm text-gray-700">Laporan yang disampaikan sesuai dengan
                        kebenaran.</label>
                </div>
                @error('konfirmasi')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Simpan</button>
        </form>
    </div>


    <script>
        $(document).ready(function() {
            // Fetch Province data on page load
            $.ajax({
                url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
                method: 'GET',
                success: function(data) {
                    data.forEach(function(province) {
                        $('#province').append(
                            `<option value="${province.name}" data-id="${province.id}">${province.name}</option>`
                            );
                    });
                },
                error: function() {
                    alert('Gagal mengambil data provinsi.');
                }
            });

            // Fetch Regency when Province is selected
            $('#province').on('change', function() {
                const provinceName = $(this).val(); // Get the selected name
                const provinceId = $('#province option:selected').data('id'); // Get the selected id
                $('#provinceName').val(provinceName); // Set name to hidden input
                $('#provinceId').val(provinceId); // Set id to hidden input

                // Clear other dropdowns
                $('#regency').empty().append(
                    '<option value="" selected disabled>-- Pilih Kabupaten/Kota --</option>');
                $('#subdistrict').empty().append(
                    '<option value="" selected disabled>-- Pilih Kecamatan --</option>');
                $('#village').empty().append(
                    '<option value="" selected disabled>-- Pilih Desa/Kelurahan --</option>');
                $('#regencyWrapper, #subdistrictWrapper, #villageWrapper').hide();

                if (provinceId) {
                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                        method: 'GET',
                        success: function(data) {
                            data.forEach(function(regency) {
                                $('#regency').append(
                                    `<option value="${regency.name}" data-id="${regency.id}">${regency.name}</option>`
                                    );
                            });
                            $('#regencyWrapper').show();
                        },
                        error: function() {
                            alert('Gagal mengambil data kabupaten.');
                        }
                    });
                }
            });

            // Fetch Subdistrict when Regency is selected
            $('#regency').on('change', function() {
                const regencyName = $(this).val(); // Get the selected name
                const regencyId = $('#regency option:selected').data('id'); // Get the selected id
                $('#regencyName').val(regencyName); // Set name to hidden input
                $('#regencyId').val(regencyId); // Set id to hidden input

                // Clear other dropdowns
                $('#subdistrict').empty().append(
                    '<option value="" selected disabled>-- Pilih Kecamatan --</option>');
                $('#village').empty().append(
                    '<option value="" selected disabled>-- Pilih Desa/Kelurahan --</option>');
                $('#subdistrictWrapper, #villageWrapper').hide();

                if (regencyId) {
                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`,
                        method: 'GET',
                        success: function(data) {
                            data.forEach(function(subdistrict) {
                                $('#subdistrict').append(
                                    `<option value="${subdistrict.name}" data-id="${subdistrict.id}">${subdistrict.name}</option>`
                                    );
                            });
                            $('#subdistrictWrapper').show();
                        },
                        error: function() {
                            alert('Gagal mengambil data kecamatan.');
                        }
                    });
                }
            });

            // Fetch Village when Subdistrict is selected
            $('#subdistrict').on('change', function() {
                const subdistrictName = $(this).val(); // Get the selected name
                const subdistrictId = $('#subdistrict option:selected').data('id'); // Get the selected id
                $('#subdistrictName').val(subdistrictName); // Set name to hidden input
                $('#subdistrictId').val(subdistrictId); // Set id to hidden input

                // Clear the village dropdown
                $('#village').empty().append(
                    '<option value="" selected disabled>-- Pilih Desa/Kelurahan --</option>');
                $('#villageWrapper').hide();

                if (subdistrictId) {
                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${subdistrictId}.json`,
                        method: 'GET',
                        success: function(data) {
                            data.forEach(function(village) {
                                $('#village').append(
                                    `<option value="${village.name}" data-id="${village.id}">${village.name}</option>`
                                    );
                            });
                            $('#villageWrapper').show();
                        },
                        error: function() {
                            alert('Gagal mengambil data desa.');
                        }
                    });
                }
            });

            // Set village name when Village is selected
            $('#village').on('change', function() {
                const villageName = $(this).val(); // Get the selected name
                $('#villageName').val(villageName); // Set name to hidden input
                const villageId = $('#village option:selected').data('id'); // Get the selected id
                $('#villageId').val(villageId); // Set id to hidden input
            });
        });
    </script>

@endsection
