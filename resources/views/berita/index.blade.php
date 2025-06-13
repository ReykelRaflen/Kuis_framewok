<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portal Berita') }}
            </h2>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('berita.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    Tambah Berita
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($beritas->count() > 0)
                <!-- Berita Utama (Featured) -->
                @if($beritas->first())
                    @php $featured = $beritas->first(); @endphp
                    <div class="mb-12">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Utama</h3>
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border">
                            <div class="md:flex">
                                <div class="md:w-1/2">
                                    <img src="{{ Storage::url($featured->foto) }}" alt="{{ $featured->judul }}" class="w-full h-64 md:h-80 object-cover">
                                </div>
                                <div class="md:w-1/2 p-8">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $featured->created_at->format('d F Y') }}</span>
                                        <span class="mx-2">•</span>
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $featured->penulis }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $featured->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                                        <a href="{{ route('berita.show', $featured) }}" class="hover:text-blue-600 transition duration-200">
                                            {{ $featured->judul }}
                                        </a>
                                    </h2>
                                    
                                    <p class="text-gray-600 mb-6 leading-relaxed">
                                        {{ Str::limit($featured->konten, 200) }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('berita.show', $featured) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                                            Baca selengkapnya
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                        
                                        @if(auth()->user()->isAdmin())
                                            <div class="flex space-x-3">
                                                <a href="{{ route('berita.edit', $featured) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium transition duration-200">
                                                    Edit
                                                </a>
                                                <form action="{{ route('berita.destroy', $featured) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium transition duration-200" onclick="return confirm('Yakin ingin menghapus?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Estimasi Waktu Baca -->
                                    <div class="flex items-center mt-4 text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                        </svg>
                                        <span>Estimasi waktu baca: {{ ceil(str_word_count($featured->konten) / 200) }} menit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Berita Terbaru -->
                @if($beritas->count() > 1)
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Terbaru</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($beritas->skip(1) as $berita)
                                <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg border hover:shadow-md transition duration-200">
                                    <div class="relative">
                                        <img src="{{ Storage::url($berita->foto) }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
                                        <!-- Badge Waktu -->
                                        <div class="absolute top-3 left-3 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs">
                                            {{ $berita->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    
                                    <div class="p-6">
                                        <!-- Meta Info -->
                                        <div class="flex items-center text-sm text-gray-500 mb-3">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $berita->created_at->format('d M Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $berita->penulis }}</span>
                                        </div>
                                        
                                        <!-- Judul -->
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3 leading-tight">
                                            <a href="{{ route('berita.show', $berita) }}" class="hover:text-blue-600 transition duration-200">
                                                {{ Str::limit($berita->judul, 80) }}
                                            </a>
                                        </h3>
                                        
                                        <!-- Excerpt -->
                                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                            {{ Str::limit($berita->konten, 120) }}
                                        </p>
                                        
                                        <!-- Footer Card -->
                                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                            <div class="flex items-center">
                                                <a href="{{ route('berita.show', $berita) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium transition duration-200">
                                                    Baca selengkapnya
                                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                            
                                            <!-- Estimasi Baca -->
                                            <div class="flex items-center text-xs text-gray-500">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>{{ ceil(str_word_count($berita->konten) / 200) }} min</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Admin Controls -->
                                        @if(auth()->user()->isAdmin())
                                            <div class="flex space-x-3 mt-3 pt-3 border-t border-gray-100">
                                                <a href="{{ route('berita.edit', $berita) }}" class="text-yellow-600 hover:text-yellow-800 text-xs font-medium transition duration-200">
                                                    Edit
                                                </a>
                                                <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium transition duration-200" onclick="return confirm('Yakin ingin menghapus?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $beritas->links() }}
                </div>

                <!-- Statistik Berita -->
                <div class="mt-12 bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-blue-600">{{ $beritas->total() }}</div>
                            <div class="text-sm text-gray-600">Total Berita</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600">{{ $beritas->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                            <div class="text-sm text-gray-600">Berita Minggu Ini</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-600">{{ $beritas->where('created_at', '>=', now()->subDay())->count() }}</div>
                            <div class="text-sm text-gray-600">Berita Hari Ini</div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada berita</h3>
                        <p class="text-gray-600 mb-6">Portal berita masih kosong. Mulai berbagi informasi dengan menulis berita pertama.</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('berita.create') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Tulis Berita Pertama
                            </a>
                        @else
                            <div class="text-sm text-gray-500">
                                Hubungi admin untuk menambahkan berita baru
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Sidebar Info (Jika ada berita) -->
            @if($beritas->count() > 0)
                <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Berita Populer -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Berita Populer
                        </h4>
                        @foreach($beritas->take(3) as $popular)
                            <div class="flex items-start space-x-3 mb-4 pb-4 border-b border-gray-100 last:border-b-0">
                                <img src="{{ Storage::url($popular->foto) }}" alt="{{ $popular->judul }}" class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <h5 class="font-medium text-sm text-gray-900 mb-1">
                                        <a href="{{ route('berita.show', $popular) }}" class="hover:text-blue-600">
                                            {{ Str::limit($popular->judul, 60) }}
                                        </a>
                                    </h5>
                                    <div class="text-xs text-gray-500">
                                        {{ $popular->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Kategori/Tags -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            Tags Populer
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">#berita</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">#terkini</span>
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">#update</span>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">#trending</span>
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">#hot</span>
                            <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">#viral</span>
                        </div>
                    </div>

                    <!-- Info Portal -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg shadow-sm border p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Tentang Portal
                        </h4>
                        <p class="text-sm text-gray-700 mb-4">
                            Portal Berita adalah platform informasi terpercaya yang menyajikan berita terkini dan akurat untuk pembaca.
                        </p>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Berita Terverifikasi
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                </svg>
                                Update Real-time
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                </svg>
                                Konten Berkualitas
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

