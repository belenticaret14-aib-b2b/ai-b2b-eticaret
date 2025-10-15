@php
    use App\Models\Kategori;
    $kategoriler = Kategori::aktif()->anaKategoriler()->with('children')->orderBy('sira')->get();
@endphp

<div class="w-64 bg-white shadow-lg rounded-lg overflow-hidden">
    <!-- Sidebar Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4">
        <h3 class="text-lg font-semibold">📂 Kategoriler</h3>
        <p class="text-sm opacity-90">Ürün kategorilerini keşfedin</p>
    </div>
    
    <!-- Categories List -->
    <div class="p-2">
        @forelse($kategoriler as $kategori)
            <div x-data="{ open: false }" class="mb-1">
                <!-- Ana Kategori -->
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md transition-colors">
                    <div class="flex items-center">
                        <span class="mr-2">📁</span>
                        {{ $kategori->ad }}
                        @if($kategori->children->count())
                            <span class="ml-2 text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
                                {{ $kategori->children->count() }}
                            </span>
                        @endif
                    </div>
                    @if($kategori->children->count())
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    @endif
                </button>
                
                <!-- Alt Kategoriler -->
                @if($kategori->children->count())
                    <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                        @foreach($kategori->children as $altKategori)
                            <a href="{{ route('urunler') }}?kategori={{ $altKategori->slug }}" 
                               class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md transition-colors">
                                <span class="mr-2">📄</span>
                                {{ $altKategori->ad }}
                                <span class="ml-2 text-xs text-gray-400">({{ $altKategori->urunler()->count() }})</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="p-4 text-center text-gray-500">
                <p>Henüz kategori bulunmuyor.</p>
            </div>
        @endforelse
    </div>
    
    <!-- Sidebar Footer -->
    <div class="bg-gray-50 p-3 border-t">
        <div class="flex items-center justify-between text-xs text-gray-500">
            <span>Toplam: {{ $kategoriler->count() }} kategori</span>
            <span>{{ $kategoriler->sum('children_count') }} alt kategori</span>
        </div>
    </div>
</div>



