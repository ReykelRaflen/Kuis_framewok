<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('berita.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-2"></i>Beranda
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ Str::limit($berita->judul, 50) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Article Header -->
            <header class="mb-8">
                <div class="flex items-center mb-4">
                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">BERITA</span>
                    <span class="ml-4 text-gray-500 text-sm">{{ $berita->created_at->format('d F Y, H:i') }} WIB</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-6">{{ $berita->judul }}</h1>
                
                <!-- Author Info -->
                <div class="flex items-center justify-between border-b border-gray-200 pb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($berita->penulis, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-semibold text-gray-900">{{ $berita->penulis }}</p>
                            <p class="text-sm text-gray-500">Penulis • {{ $berita->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <!-- Social Share -->
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition duration-300">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="text-blue-400 hover:text-blue-600 transition duration-300">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" target="_blank" class="text-green-600 hover:text-green-800 transition duration-300">
                            <i class="fab fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Featured Image -->
            <div class="mb-8">
                <img src="{{ Storage::url($berita->foto) }}" alt="{{ $berita->judul }}" class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg">
                <p class="text-sm text-gray-500 mt-2 text-center italic">{{ $berita->judul }}</p>
            </div>

            <!-- Article Content -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-800 leading-relaxed text-lg whitespace-pre-line">{{ $berita->konten }}</p>
                </div>
                
                <!-- Tags -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center flex-wrap">
                        <span class="text-sm text-gray-500 mr-3">Tags:</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm mr-2 mb-2">#berita</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm mr-2 mb-2">#terkini</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm mr-2 mb-2">#{{ strtolower(str_replace(' ', '', $berita->penulis)) }}</span>
                    </div>
                </div>
            </div>

            <!-- Admin Actions -->
            @if(auth()->user()->isAdmin())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-crown text-yellow-600 mr-2"></i>
                            <span class="text-yellow-800 font-semibold">Panel Admin</span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('berita.edit', $berita) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                <i class="fas fa-edit mr-2"></i>Edit Berita
                            </a>
                            <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                    <i class="fas fa-trash mr-2"></i>Hapus Berita
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <div class="flex items-center justify-between bg-white rounded-lg shadow-lg p-6">
                <a href="{{ route('berita.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 font-semibold transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
                
                <!-- Reading Time -->
                <div class="flex items-center text-gray-500">
                    <i class="fas fa-clock mr-2"></i>
                    <span class="text-sm">{{ ceil(str_word_count($berita->konten) / 200) }} menit baca</span>
                </div>
            </div>
        </article>

        <!-- Related Articles -->
        @php
            $relatedArticles = App\Models\Berita::where('id', '!=', $berita->id)->latest()->take(3)->get();
        @endphp
        
        @if($relatedArticles->count() > 0)
            <section class="bg-white py-12 mt-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Berita Terkait</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedArticles as $related)
                            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                                <img src="{{ Storage::url($related->foto) }}" alt="{{ $related->judul }}" class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">
                                        <a href="{{ route('berita.show', $related) }}" class="hover:text-blue-600 transition duration-300">{{ Str::limit($related->judul, 60) }}</a>
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($related->konten, 100) }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">{{ $related->created_at->format('d M Y') }}</span>
                                        <a href="{{ route('berita.show', $related) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">Baca →</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
