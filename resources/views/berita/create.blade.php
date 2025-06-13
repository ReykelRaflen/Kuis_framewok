<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Berita Baru') }}
            </h2>
            <a href="{{ route('berita.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                Kembali ke Portal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Panel -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 mb-1">Tips Menulis Berita</h3>
                        <div class="text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Gunakan judul yang menarik dan informatif</li>
                                <li>Pilih foto berkualitas tinggi (max 2MB)</li>
                                <li>Tulis konten yang jelas dan mudah dipahami</li>
                                <li>Periksa kembali sebelum mempublikasikan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Judul Berita -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Berita <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                   placeholder="Masukkan judul berita yang menarik..."
                                   maxlength="255">
                            <div class="flex justify-between mt-1">
                                @error('judul')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Judul yang baik akan menarik pembaca</p>
                                @enderror
                                <span id="judul-count" class="text-sm text-gray-400">0/255</span>
                            </div>
                        </div>

                        <!-- Nama Penulis -->
                        <div>
                            <label for="penulis" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Penulis <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" name="penulis" id="penulis" value="{{ old('penulis', auth()->user()->name) }}"
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       placeholder="Nama penulis berita">
                            </div>
                            @error('penulis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Nama penulis akan ditampilkan di artikel</p>
                            @enderror
                        </div>

                        <!-- Foto Berita -->
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Berita <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload foto</span>
                                            <input id="foto" name="foto" type="file" accept="image/*" class="sr-only" onchange="previewImage(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                            
                            <!-- Preview Image -->
                            <div id="image-preview" class="mt-4 hidden">
                                <img id="preview-img" class="w-full h-64 object-cover rounded-lg shadow-md" alt="Preview">
                                <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                                    Hapus foto
                                </button>
                            </div>
                            
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Pilih foto yang relevan dengan berita Anda</p>
                            @enderror
                        </div>

                        <!-- Konten Berita -->
                        <div>
                            <label for="konten" class="block text-sm font-medium text-gray-700 mb-2">
                                Konten Berita <span class="text-red-500">*</span>
                            </label>
                            <textarea name="konten" id="konten" rows="12"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                      placeholder="Tulis konten berita di sini...

Tips:
- Mulai dengan lead yang menarik
- Gunakan paragraf pendek untuk kemudahan baca
- Sertakan fakta dan data yang akurat
- Akhiri dengan kesimpulan yang kuat">{{ old('konten') }}</textarea>
                            <div class="flex justify-between mt-1">
                                @error('konten')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Tulis konten yang informatif dan mudah dipahami</p>
                                @enderror
                                <div class="text-sm text-gray-400">
                                    <span id="word-count">0</span> kata • 
                                    <span id="read-time">0</span> menit baca
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('berita.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L3 11.414A2 2 0 013 8.586l3.293-3.293a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Publikasikan Berita
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="mt-8 bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Artikel</h3>
                <div id="preview-content" class="bg-white rounded-lg p-6 border">
                    <div class="text-gray-500 text-center py-8">
                        Mulai menulis untuk melihat preview artikel...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Character counter for title
        document.getElementById('judul').addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById('judul-count').textContent = count + '/255';
            updatePreview();
        });

        // Word counter and reading time for content
        document.getElementById('konten').addEventListener('input', function() {
            const words = this.value.trim().split(/\s+/).filter(word => word.length > 0).length;
            const readTime = Math.ceil(words / 200);
            document.getElementById('word-count').textContent = words;
            document.getElementById('read-time').textContent = readTime;
            updatePreview();
        });

        // Image preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            document.getElementById('foto').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        }

        // Live preview
        function updatePreview() {
            const judul = document.getElementById('judul').value;
            const penulis = document.getElementById('penulis').value;
            const konten = document.getElementById('konten').value;
            
            if (judul || konten) {
                const previewHtml = `
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">${judul || 'Judul Berita'}</h1>
                        <div class="text-sm text-gray-600 mb-4">
                            <span>Oleh: ${penulis || 'Penulis'}</span> • 
                            <span>${new Date().toLocaleDateString('id-ID')}</span>
                        </div>
                    </div>
                                        <div class="prose max-w-none">
                        <div class="text-gray-800 leading-relaxed whitespace-pre-line">${konten || 'Konten berita akan muncul di sini...'}</div>
                    </div>
                `;
                document.getElementById('preview-content').innerHTML = previewHtml;
            } else {
                document.getElementById('preview-content').innerHTML = `
                    <div class="text-gray-500 text-center py-8">
                        Mulai menulis untuk melihat preview artikel...
                    </div>
                `;
            }
        }

        // Auto-save draft (optional)
        let autoSaveTimer;
        function autoSave() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                const formData = {
                    judul: document.getElementById('judul').value,
                    penulis: document.getElementById('penulis').value,
                    konten: document.getElementById('konten').value
                };
                localStorage.setItem('berita_draft', JSON.stringify(formData));
                console.log('Draft saved');
            }, 2000);
        }

        // Load draft on page load
        window.addEventListener('load', function() {
            const draft = localStorage.getItem('berita_draft');
            if (draft) {
                const data = JSON.parse(draft);
                if (confirm('Ditemukan draft yang belum selesai. Muat draft?')) {
                    document.getElementById('judul').value = data.judul || '';
                    document.getElementById('penulis').value = data.penulis || '';
                    document.getElementById('konten').value = data.konten || '';
                    updatePreview();
                }
            }
        });

        // Add auto-save listeners
        ['judul', 'penulis', 'konten'].forEach(id => {
            document.getElementById(id).addEventListener('input', autoSave);
        });

        // Clear draft on successful submit
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('berita_draft');
        });
    </script>
</x-app-layout>

