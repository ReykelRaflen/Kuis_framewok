<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Berita') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('berita.show', $berita) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    Lihat Berita
                </a>
                <a href="{{ route('berita.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    Kembali ke Portal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Panel -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800 mb-1">Mode Edit</h3>
                        <div class="text-sm text-yellow-700">
                            <p>Anda sedang mengedit berita yang sudah dipublikasikan. Perubahan akan langsung terlihat setelah disimpan.</p>
                            <p class="mt-1"><strong>Terakhir diupdate:</strong> {{ $berita->updated_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Judul Berita -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Berita <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $berita->judul) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                   placeholder="Masukkan judul berita yang menarik..."
                                   maxlength="255">
                            <div class="flex justify-between mt-1">
                                @error('judul')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Judul yang baik akan menarik pembaca</p>
                                @enderror
                                <span id="judul-count" class="text-sm text-gray-400">{{ strlen($berita->judul) }}/255</span>
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
                                <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $berita->penulis) }}"
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       placeholder="Nama penulis berita">
                            </div>
                            @error('penulis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Nama penulis akan ditampilkan di artikel</p>
                            @enderror
                        </div>

                        <!-- Foto Saat Ini -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                            <div class="relative inline-block">
                                <img src="{{ Storage::url($berita->foto) }}" alt="{{ $berita->judul }}" 
                                     class="w-full max-w-md h-48 object-cover rounded-lg shadow-md">
                                <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">
                                    Foto Aktif
                                </div>
                            </div>
                        </div>

                        <!-- Upload Foto Baru -->
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                Ganti Foto (Opsional)
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload foto baru</span>
                                            <input id="foto" name="foto" type="file" accept="image/*" class="sr-only" onchange="previewImage(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                            
                            <!-- Preview New Image -->
                            <div id="image-preview" class="mt-4 hidden">
                                <div class="relative">
                                    <img id="preview-img" class="w-full max-w-md h-48 object-cover rounded-lg shadow-md" alt="Preview">
                                    <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs">
                                        Foto Baru
                                    </div>
                                </div>
                                <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                                    Batalkan perubahan foto
                                </button>
                            </div>
                            
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti foto</p>
                            @enderror
                        </div>

                        <!-- Konten Berita -->
                        <div>
                            <label for="konten" class="block text-sm font-medium text-gray-700 mb-2">
                                Konten Berita <span class="text-red-500">*</span>
                            </label>
                            <textarea name="konten" id="konten" rows="12"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                      placeholder="Tulis konten berita di sini...">{{ old('konten', $berita->konten) }}</textarea>
                            <div class="flex justify-between mt-1">
                                @error('konten')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Tulis konten yang informatif dan mudah dipahami</p>
                                @enderror
                                <div class="text-sm text-gray-400">
                                    <span id="word-count">{{ str_word_count($berita->konten) }}</span> kata • 
                                    <span id="read-time">{{ ceil(str_word_count($berita->konten) / 200) }}</span> menit baca
                                </div>
                            </div>
                        </div>

                        <!-- Revision History -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Riwayat Revisi</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Dipublikasikan: {{ $berita->created_at->format('d F Y, H:i') }} WIB</span>
                                </div>
                                @if($berita->updated_at != $berita->created_at)
                                                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Terakhir diupdate: {{ $berita->updated_at->format('d F Y, H:i') }} WIB</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('berita.show', $berita) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Preview
                                </a>
                                <a href="{{ route('berita.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L3 11.414A2 2 0 013 8.586l3.293-3.293a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Batal
                                </a>
                            </div>
                            <div class="flex space-x-3">
                                <button type="button" onclick="saveDraft()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"></path>
                                    </svg>
                                    Simpan Draft
                                </button>
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Update Berita
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Live Preview Panel -->
            <div class="mt-8 bg-gray-50 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Live Preview</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Auto-update:</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="auto-preview" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
                <div id="preview-content" class="bg-white rounded-lg p-6 border">
                    <!-- Initial preview content -->
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $berita->judul }}</h1>
                        <div class="text-sm text-gray-600 mb-4">
                            <span>Oleh: {{ $berita->penulis }}</span> • 
                            <span>{{ $berita->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <div class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $berita->konten }}</div>
                    </div>
                </div>
            </div>

            <!-- Comparison Panel -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Perbandingan Perubahan</h3>
                    <p class="text-sm text-gray-600 mt-1">Lihat perbedaan antara versi asli dan yang sedang diedit</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Original Version -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                Versi Asli
                            </h4>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 max-h-64 overflow-y-auto">
                                <h5 class="font-medium text-sm mb-2">{{ $berita->judul }}</h5>
                                <p class="text-xs text-gray-600 mb-2">{{ $berita->penulis }}</p>
                                <div class="text-sm text-gray-700">{{ Str::limit($berita->konten, 200) }}</div>
                            </div>
                        </div>
                        
                        <!-- Current Edit -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                Sedang Diedit
                            </h4>
                            <div id="current-edit" class="bg-green-50 border border-green-200 rounded-lg p-4 max-h-64 overflow-y-auto">
                                <h5 class="font-medium text-sm mb-2">{{ $berita->judul }}</h5>
                                <p class="text-xs text-gray-600 mb-2">{{ $berita->penulis }}</p>
                                <div class="text-sm text-gray-700">{{ Str::limit($berita->konten, 200) }}</div>
                            </div>
                        </div>
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
            if (document.getElementById('auto-preview').checked) {
                updatePreview();
                updateComparison();
            }
        });

        // Word counter and reading time for content
        document.getElementById('konten').addEventListener('input', function() {
            const words = this.value.trim().split(/\s+/).filter(word => word.length > 0).length;
            const readTime = Math.ceil(words / 200);
            document.getElementById('word-count').textContent = words;
            document.getElementById('read-time').textContent = readTime;
            if (document.getElementById('auto-preview').checked) {
                updatePreview();
                updateComparison();
            }
        });

        // Penulis change
        document.getElementById('penulis').addEventListener('input', function() {
            if (document.getElementById('auto-preview').checked) {
                updatePreview();
                updateComparison();
            }
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
            
            const previewHtml = `
                <div class="mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">${judul}</h1>
                    <div class="text-sm text-gray-600 mb-4">
                        <span>Oleh: ${penulis}</span> • 
                        <span>${new Date().toLocaleDateString('id-ID')}</span>
                    </div>
                </div>
                <div class="prose max-w-none">
                    <div class="text-gray-800 leading-relaxed whitespace-pre-line">${konten}</div>
                </div>
            `;
            document.getElementById('preview-content').innerHTML = previewHtml;
        }

        // Update comparison
        function updateComparison() {
            const judul = document.getElementById('judul').value;
            const penulis = document.getElementById('penulis').value;
            const konten = document.getElementById('konten').value;
            
            const currentEditHtml = `
                <h5 class="font-medium text-sm mb-2">${judul}</h5>
                <p class="text-xs text-gray-600 mb-2">${penulis}</p>
                <div class="text-sm text-gray-700">${konten.substring(0, 200)}${konten.length > 200 ? '...' : ''}</div>
            `;
            document.getElementById('current-edit').innerHTML = currentEditHtml;
        }

        // Save draft function
        function saveDraft() {
            const formData = {
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                konten: document.getElementById('konten').value
            };
            localStorage.setItem('berita_edit_draft_{{ $berita->id }}', JSON.stringify(formData));
            
            // Show notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            notification.textContent = 'Draft berhasil disimpan!';
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        //
                // Auto-save functionality
        let autoSaveTimer;
        function autoSave() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                saveDraft();
            }, 5000); // Auto-save every 5 seconds
        }

        // Load draft on page load
        window.addEventListener('load', function() {
            const draft = localStorage.getItem('berita_edit_draft_{{ $berita->id }}');
            if (draft) {
                const data = JSON.parse(draft);
                if (confirm('Ditemukan draft perubahan yang belum disimpan. Muat draft?')) {
                    document.getElementById('judul').value = data.judul || '';
                    document.getElementById('penulis').value = data.penulis || '';
                    document.getElementById('konten').value = data.konten || '';
                    updatePreview();
                    updateComparison();
                    
                    // Update counters
                    const judulCount = data.judul ? data.judul.length : 0;
                    document.getElementById('judul-count').textContent = judulCount + '/255';
                    
                    const words = data.konten ? data.konten.trim().split(/\s+/).filter(word => word.length > 0).length : 0;
                    const readTime = Math.ceil(words / 200);
                    document.getElementById('word-count').textContent = words;
                    document.getElementById('read-time').textContent = readTime;
                }
            }
        });

        // Add auto-save listeners
        ['judul', 'penulis', 'konten'].forEach(id => {
            document.getElementById(id).addEventListener('input', autoSave);
        });

        // Clear draft on successful submit
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('berita_edit_draft_{{ $berita->id }}');
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S to save draft
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveDraft();
            }
            
            // Ctrl+Enter to submit form
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                document.querySelector('form').submit();
            }
        });

        // Warn before leaving page with unsaved changes
        let hasUnsavedChanges = false;
        ['judul', 'penulis', 'konten'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                hasUnsavedChanges = true;
            });
        });

        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });

        // Remove warning when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            hasUnsavedChanges = false;
        });

        // Toggle auto-preview
        document.getElementById('auto-preview').addEventListener('change', function() {
            if (this.checked) {
                updatePreview();
                updateComparison();
            }
        });

        // Initialize counters on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize title counter
            const currentTitle = document.getElementById('judul').value;
            document.getElementById('judul-count').textContent = currentTitle.length + '/255';
            
            // Initialize word counter
            const currentContent = document.getElementById('konten').value;
            const words = currentContent.trim().split(/\s+/).filter(word => word.length > 0).length;
            const readTime = Math.ceil(words / 200);
            document.getElementById('word-count').textContent = words;
            document.getElementById('read-time').textContent = readTime;
        });

        // Drag and drop functionality for file upload
        const dropZone = document.querySelector('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-blue-400', 'bg-blue-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    document.getElementById('foto').files = files;
                    previewImage(document.getElementById('foto'));
                }
            }
        }

        // Text formatting shortcuts (basic)
        document.getElementById('konten').addEventListener('keydown', function(e) {
            // Tab for indentation
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                
                this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 4;
            }
        });

        // Show notification for successful operations
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Enhanced save draft with better feedback
        function saveDraft() {
            const formData = {
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                konten: document.getElementById('konten').value,
                timestamp: new Date().toISOString()
            };
            localStorage.setItem('berita_edit_draft_{{ $berita->id }}', JSON.stringify(formData));
            showNotification('Draft berhasil disimpan!');
        }
    </script>

    <!-- Custom Styles -->
    <style>
        /* Custom scrollbar for preview areas */
        .max-h-64::-webkit-scrollbar {
            width: 6px;
        }
        
        .max-h-64::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .max-h-64::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .max-h-64::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Highlight changes in comparison */
        .comparison-highlight {
            background-color: #fef3c7;
            padding: 2px 4px;
            border-radius: 3px;
        }

        /* Loading state for buttons */
        .btn-loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Focus states */
        input:focus, textarea:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Drag and drop states */
        .border-dashed.border-blue-400 {
            border-color: #60a5fa !important;
            background-color: #eff6ff !important;
        }
    </style>
</x-app-layout>


