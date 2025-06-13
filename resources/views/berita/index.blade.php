<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">BeritaKu</h1>
                <p class="text-xl md:text-2xl mb-8">Portal Berita Terpercaya dan Terkini</p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('berita.create') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-6 rounded-full transition duration-300 shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Tulis Berita Baru
                    </a>
                @endif
            </div>
        </div>

        <!-- Breaking News Ticker -->
        <div class="bg-red-600 text-white py-2 overflow-hidden">
            <div class="flex items-center">
                <div class="bg-red-800 px-4 py-1 font-bold text-sm">BREAKING NEWS</div>
                <div class="flex-1 px-4">
                    <div class="animate-marquee whitespace-nowrap">
                        @if($beritas->count() > 0)
                            @foreach($beritas->take(3) as $berita)
                                <span class="mx-8">{{ $berita->judul }}</span>
                            @endforeach
                        @else
                            <span>Selamat datang di BeritaKu - Portal berita terpercaya</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($beritas->count() > 0)
                <!-- Featured Article -->
                @if($beritas->first())
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-4 border-blue-600 pb-2">Berita Utama</h2>
                        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                            <div class="md:flex">
                                <div class="md:w-1/2">
                                    <img src="{{ Storage::url($beritas->first()->foto) }}" alt="{{ $beritas->first()->judul }}" class="w-full h-64 md:h-full object-cover">
                                </div>
                                <div class="md:w-1/2 p-8">
                                    <div class="flex items-center mb-4">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">TRENDING</span>
                                        <span class="ml-4 text-gray-500 text-sm">{{ $beritas->first()->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">{{ $beritas->first()->judul }}</h3>
                                    <p class="text-gray-600 mb-6 leading-relaxed">{{ Str::limit($beritas->first()->konten, 200) }}</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ substr($beritas->first()->penulis, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-semibold text-gray-900">{{ $beritas->first()->penulis }}</p>
                                                <p class="text-xs text-gray-500">Penulis</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('berita.show', $beritas->first()) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition duration-300">
                                            Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Latest News Grid -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-4 border-blue-600 pb-2">Berita Terbaru</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($beritas->skip(1) as $berita)
                            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                                <div class="relative">
                                    <img src="{{ Storage::url($berita->foto) }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">NEWS</span>
                                    </div>
                                    @if(auth()->user()->isAdmin())
                                        <div class="absolute top-4 right-4 flex space-x-2">
                                            <a href="{{ route('berita.edit', $berita) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-full transition duration-300">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full transition duration-300" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center mb-3">
                                        <span class="text-gray-500 text-sm">{{ $berita->created_at->format('d M Y') }}</span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        <span class="text-gray-500 text-sm">{{ $berita->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-3 leading-tight hover:text-blue-600 transition duration-300">
                                        <a href="{{ route('berita.show', $berita) }}">{{ $berita->judul }}</a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">{{ Str::limit($berita->konten, 120) }}</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($berita->penulis, 0, 1) }}
                                            </div>
                                            <span class="ml-2 text-sm text-gray-600">{{ $berita->penulis }}</span>
                                        </div>
                                        <a href="{{ route('berita.show', $berita) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm transition duration-300">
                                            Baca →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $beritas->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Berita</h3>
                        <p class="text-gray-600 mb-8">Portal berita sedang dalam tahap pengembangan. Berita pertama akan segera hadir!</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('berita.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>Tulis Berita Pertama
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-12 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="text-2xl font-bold mb-4">BeritaKu</h3>
                        <p class="text-gray-300 mb-4">Portal berita terpercaya yang menyajikan informasi terkini dan akurat untuk masyarakat Indonesia.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Kategori</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-300 hover:text-white transition duration-300">Politik</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition duration-300">Ekonomi</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition duration-300">Olahraga</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition duration-300">Teknologi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                        <ul class="space-y-2 text-gray-300">
                            <li><i class="fas fa-envelope mr-2"></i>info@beritaku.com</li>
                            <li><i class="fas fa-phone mr-2"></i>+62 21 1234 5678</li>
                            <li><i class="fas fa-map-marker-alt mr-2"></i>Jakarta, Indonesia</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-300">&copy; {{ date('Y') }} BeritaKu. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <style>
        @keyframes marquee {
            0% { transform: translate3d(100%, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
    </style>
</x-app-layout>
