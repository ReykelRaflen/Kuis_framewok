<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Tulis Berita Baru</h1>
                        <p class="text-gray-600 mt-2">Bagikan informasi terkini kepada pembaca</p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-pen-fancy text-4xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    <!-- Judul -->
                    <div class="mb-8">
                        <label for="judul" class="block text-lg font-semibold text-gray-700 mb-3">
                            <i class="fas fa-heading mr-2 text-blue-600"></i>Judul Berita
                        </label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                               placeholder="Masukkan judul berita yang menarik...">
                        @error('judul')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Penulis -->
                    <div class="mb-8">
                        <label for="penulis" class="block text-lg font-semibold text-gray-700 mb-3">
                            <i class="fas fa-user-edit mr-2 text-blue-600"></i>Nama Penulis
                        </label>
                        <input type="text" name="penulis" id="penulis" value="{{ old('penulis', auth()->user()->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Nama penulis berita">
                        @error('penulis')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div class="mb-8">
                        <label for="foto" class="block text-lg font-semibold text-gray-700 mb-3">
                            <i class="fas fa-image mr-2 text-blue-600"></i>Foto Berita
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition duration-300">
                            <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                            <div id="upload-area" onclick="document.getElementById('foto').click()" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 mb-2">Klik untuk upload foto atau drag & drop</p>
                                <p class="text-sm text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-img" src="" alt="Preview" class="max-w-full h-64 object-cover rounded-lg mx-auto">
                                <p class="text-sm text-gray-600 mt-2">Klik untuk mengganti foto</p>
                            </div>
                        </div>
                        @error('foto')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
