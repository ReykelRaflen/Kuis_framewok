<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Berita') }}
            </h2>
            <a href="{{ route('berita.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Berita -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $berita->judul }}</h1>
                        
                        <!-- Info Berita -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <div class="flex flex-wrap items-center text-sm text-gray-600 mb-3">
                                <div class="flex items-center mr-6">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Oleh: <strong>{{ $berita->penulis }}</strong></span>
                                </div>
                                <div class="flex items-center mr-6">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $berita->created_at->format('d F Y') }}</span>
                                </div>
                                <div class="flex items-center mr-6">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $berita->created_at->format('H:i') }} WIB</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $berita->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <!-- Estimasi Waktu Baca -->
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                </svg>
                                <span>Estimasi waktu baca: {{ ceil(str_word_count($berita->konten) / 200) }} menit</span>
                            </div>
                        </div>
                        
                        @if(auth()->user()->isAdmin())
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-yellow-800 font-medium">Panel Admin</span>
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('berita.edit', $berita) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-sm transition duration-200">
                                            Edit Berita
                                        </a>
                                        <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded text-sm transition duration-200" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                                Hapus Berita
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Foto Berita -->
                    <div class="mb-8">
                        <figure>
                            <img src="{{ Storage::url($berita->foto) }}" alt="{{ $berita->judul }}" class="w-full h-64 md:h-96 object-cover rounded-lg shadow-md">
                            <figcaption class="text-sm text-gray-500 mt-2 text-center italic">
                                {{ $berita->judul }}
                            </figcaption>
                        </figure>
                    </div>

                    <!-- Konten Berita -->
                    <article class="prose prose-lg max-w-none">
                        <div class="text-gray-800 leading-relaxed text-justify whitespace-pre-line text-base md:text-lg">
                            {{ $berita->konten }}
                        </div>
                    </article>

                    <!-- Footer Artikel -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <!-- Tags -->
                        <div class="mb-4">
                            <div class="flex flex-wrap items-center">
                                <span class="text-sm text-gray-600 mr-3 font-medium">Tags:</span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm mr-2 mb-2">#berita</span>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm mr-2 mb-2">#terkini</span>
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm mr-2 mb-2">#{{ strtolower(str_replace(' ', '', $berita->penulis)) }}</span>
                            </div>
                        </div>

                        <!-- Share Buttons -->
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-600 mr-4 font-medium">Bagikan artikel ini:</span>
                                <div class="flex space-x-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition duration-200">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="text-blue-400 hover:text-blue-600 transition duration-200">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" target="_blank" class="text-green-600 hover:text-green-800 transition duration-200">
                                                                               <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.63z"/>
                                        </svg>
                                    </a>
                                    <button onclick="copyToClipboard()" class="text-gray-600 hover:text-gray-800 transition duration-200" title="Salin Link">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span>{{ $berita->created_at->format('d F Y, H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Penulis -->
                    <div class="mt-8 bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Tentang Penulis</h3>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xl">{{ substr($berita->penulis, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900">{{ $berita->penulis }}</h4>
                                <p class="text-gray-600 text-sm mt-1">
                                    Penulis berita di Portal Berita. Berpengalaman dalam menulis artikel informatif dan terkini.
                                </p>
                                <div class="flex items-center mt-3 text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Kontributor aktif sejak {{ $berita->created_at->format('Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Berita Terkait -->
                    @php
                        $beritaTerkait = \App\Models\Berita::where('id', '!=', $berita->id)
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp

                    @if($beritaTerkait->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Berita Terkait</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($beritaTerkait as $related)
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition duration-200">
                                        <img src="{{ Storage::url($related->foto) }}" alt="{{ $related->judul }}" class="w-full h-32 object-cover">
                                        <div class="p-4">
                                            <div class="text-xs text-gray-500 mb-2">
                                                {{ $related->created_at->format('d M Y') }}
                                            </div>
                                            <h4 class="font-medium text-gray-900 mb-2 line-clamp-2">
                                                <a href="{{ route('berita.show', $related) }}" class="hover:text-blue-600">
                                                    {{ Str::limit($related->judul, 60) }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-3">
                                                {{ Str::limit($related->konten, 80) }}
                                            </p>
                                            <a href="{{ route('berita.show', $related) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Baca selengkapnya →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Navigasi Berita -->
                    @php
                        $prevBerita = \App\Models\Berita::where('id', '<', $berita->id)->orderBy('id', 'desc')->first();
                        $nextBerita = \App\Models\Berita::where('id', '>', $berita->id)->orderBy('id', 'asc')->first();
                    @endphp

                    @if($prevBerita || $nextBerita)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                @if($prevBerita)
                                    <a href="{{ route('berita.show', $prevBerita) }}" class="flex items-center text-blue-600 hover:text-blue-800 group">
                                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="text-left">
                                            <div class="text-sm text-gray-500">Berita Sebelumnya</div>
                                            <div class="font-medium">{{ Str::limit($prevBerita->judul, 40) }}</div>
                                        </div>
                                    </a>
                                @else
                                    <div></div>
                                @endif

                                @if($nextBerita)
                                    <a href="{{ route('berita.show', $nextBerita) }}" class="flex items-center text-blue-600 hover:text-blue-800 group text-right">
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">Berita Selanjutnya</div>
                                            <div class="font-medium">{{ Str::limit($nextBerita->judul, 40) }}</div>
                                        </div>
                                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Copy Link -->
    <script>
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                // Tampilkan notifikasi
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = 'Link berhasil disalin!';
                document.body.appendChild(notification);
                
                // Hapus notifikasi setelah 3 detik
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }).catch(function(err) {
                console.error('Gagal menyalin link: ', err);
            });
        }
    </script>
</x-app-layout>
