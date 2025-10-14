@extends('layouts.app')

@section('title', 'Admin Paneli')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">⚙️ Admin Paneli</h1>
                    <p class="mt-2 text-gray-600">Sistem yönetimi ve kontrolü</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('anasayfa') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        🏠 Ana Sayfa
                    </a>
                </div>
            </div>
        </div>

    @if (session('status'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        @isset($istatistik)
        <!-- İstatistik Kartları -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Toplam Ürün</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $istatistik['urun'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-box text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Toplam Mağaza</p>
                        <p class="text-2xl font-bold text-green-600">{{ $istatistik['magaza'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-store text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Toplam Bayi</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $istatistik['bayi'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-handshake text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Toplam Sipariş</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $istatistik['siparis'] ?? 0 }}</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="fas fa-shopping-cart text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        @endisset
        @endisset

        <!-- Hızlı Erişim Menüleri -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.urun.index') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Ürün Yönetimi</h3>
                    <i class="fas fa-box text-blue-500 text-2xl"></i>
                </div>
                <p class="text-gray-600">Ürünleri görüntüleyin, ekleyin ve düzenleyin.</p>
            </a>

            <a href="{{ route('admin.magaza.index') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Mağaza Yönetimi</h3>
                    <i class="fas fa-store text-green-500 text-2xl"></i>
                </div>
                <p class="text-gray-600">Mağazaları yönetin ve platform entegrasyonlarını kontrol edin.</p>
            </a>

            <a href="{{ route('admin.sayfalar') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Sayfa Yönetimi</h3>
                    <i class="fas fa-file-alt text-purple-500 text-2xl"></i>
                </div>
                <p class="text-gray-600">İçerik sayfalarını düzenleyin ve yönetin.</p>
            </a>

            <a href="{{ route('admin.site-ayarlari') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Site Ayarları</h3>
                    <i class="fas fa-cogs text-yellow-500 text-2xl"></i>
                </div>
                <p class="text-gray-600">Genel site ayarlarını yapılandırın.</p>
            </a>

            <a href="{{ route('admin.xml.export') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">XML Export</h3>
                    <i class="fas fa-download text-red-500 text-2xl"></i>
                </div>
                <p class="text-gray-600">Ürün verilerini XML formatında dışa aktarın.</p>
            </a>

            <a href="{{ route('admin.xml.import') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">XML Import</h3>
                    <i class="fas fa-upload text-indigo-500 text-2xl"></i>
                </div>
                <p class="text-gray-600">XML dosyalarından ürün verilerini içe aktarın.</p>
            </a>

        </div>

    @isset($sonUrunler)
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Son Eklenen Ürünler</span>
                    <a href="{{ route('admin.urun.index') }}" class="btn btn-sm btn-outline-secondary">Tümü</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Ad</th>
                                    <th>Fiyat</th>
                                    <th>Eklenme</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sonUrunler as $u)
                                    <tr>
                                        <td style="width:56px;">
                                            @php
                                                $img = $u->gorsel ?? null;
                                                $src = $img ? (Str::startsWith($img, ['http://','https://']) ? $img : asset('storage/'.$img)) : 'https://placehold.co/48x48?text=U';
                                            @endphp
                                            <img src="{{ $src }}" alt="{{ $u->ad }}" class="rounded" style="width:48px;height:48px;object-fit:cover;">
                                        </td>
                                        <td class="fw-semibold">{{ $u->ad }}</td>
                                        <td>{{ number_format($u->fiyat,2) }} ₺</td>
                                        <td>{{ $u->created_at?->format('d.m.Y H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.urun.edit', $u) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Kayıt yok.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">Stok Özet</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Toplam Stok Adedi</span>
                        <span class="fw-semibold">{{ number_format($stokToplam ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Stok Değeri (₺)</span>
                        <span class="fw-semibold">{{ number_format(($stokDegeri ?? 0), 2) }} ₺</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endisset

    @isset($dusukStokler)
    <div class="card mb-4">
        <div class="card-header">Düşük Stoklu Ürünler (≤ 5)</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm mb-0 align-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Ad</th>
                            <th>Stok</th>
                            <th>Fiyat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dusukStokler as $u)
                            <tr>
                                <td style="width:56px;">
                                    @php
                                        $img = $u->gorsel ?? null;
                                        $src = $img ? (Str::startsWith($img, ['http://','https://']) ? $img : asset('storage/'.$img)) : 'https://placehold.co/48x48?text=U';
                                    @endphp
                                    <img src="{{ $src }}" alt="{{ $u->ad }}" class="rounded" style="width:48px;height:48px;object-fit:cover;">
                                </td>
                                <td class="fw-semibold">{{ $u->ad }}</td>
                                <td><span class="badge text-bg-warning">{{ $u->stok ?? '-' }}</span></td>
                                <td>{{ number_format($u->fiyat,2) }} ₺</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.urun.edit', $u) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Liste boş.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endisset

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded p-4">
            <h2 class="font-semibold mb-3">Hızlı İşlemler</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.magaza.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Mağaza Ekle</a>
                <a href="{{ route('admin.xml.export') }}" class="px-3 py-2 bg-emerald-600 text-white rounded">XML Dışa Aktar</a>
                <form action="{{ route('admin.xml.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                    @csrf
                    <input type="file" name="xml" accept=".xml" class="border rounded px-2 py-1" required>
                    <button type="submit" class="px-3 py-2 bg-amber-600 text-white rounded">XML İçe Aktar</button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h2 class="font-semibold mb-3">AI Ürün Önerisi</h2>
            <form id="aiForm" action="{{ route('admin.ai.urunOnerisi') }}" method="POST">
                @csrf
                <label class="block text-sm mb-1" for="ai_metin">Anahtar Kelimeler / Açıklama</label>
                <textarea id="ai_metin" name="metin" rows="3" class="w-full border rounded px-2 py-1" placeholder="Örn: okul, kırtasiye, uygun fiyat" required></textarea>
                <button type="submit" class="mt-2 btn btn-primary">Öneri Getir</button>
            </form>
            <button type="button" id="aiSubmitBtn" class="btn btn-outline-primary btn-sm mt-2">Öneri Getir (Alternatif)</button>
            <div id="aiSonuc" class="mt-3 text-sm text-gray-800 hidden"></div>
        </div>

        <div class="bg-white shadow rounded p-4 md:col-span-2">
            <h2 class="font-semibold mb-3">Barkod ile Ürün Sorgula</h2>
            <form id="barkodForm" action="{{ route('admin.barkod.fetch') }}" method="POST" class="flex flex-wrap gap-2 items-center">
                @csrf
                <input type="text" name="barkod" placeholder="Barkod No" class="border rounded px-2 py-1" required>
                <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded">Sorgula</button>
            </form>
            <div id="barkodSonuc" class="mt-3 text-sm text-gray-800 hidden"></div>
        </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    const aiForm = document.getElementById('aiForm');
    const aiSonuc = document.getElementById('aiSonuc');
    if (aiForm) {
        aiForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            aiSonuc.classList.remove('hidden');
            aiSonuc.textContent = 'Öneriler getiriliyor...';
            try {
                const formData = new FormData(aiForm);
                const res = await fetch(aiForm.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const ct = res.headers.get('content-type') || '';
                if (ct.includes('application/json')) {
                    const data = await res.json();
                    aiSonuc.textContent = (data.oneri || data.sonuc || data.message || JSON.stringify(data));
                } else {
                    const text = await res.text();
                    aiSonuc.innerHTML = text;
                }
            } catch (err) {
                aiSonuc.textContent = 'Öneri alınırken hata oluştu.';
            }
        });
    }
    const aiSubmitBtn = document.getElementById('aiSubmitBtn');
    if (aiSubmitBtn && aiForm) {
        aiSubmitBtn.addEventListener('click', () => aiForm.requestSubmit());
    }

    const barkodForm = document.getElementById('barkodForm');
    const barkodSonuc = document.getElementById('barkodSonuc');
    if (barkodForm) {
        barkodForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            barkodSonuc.classList.remove('hidden');
            barkodSonuc.textContent = 'Sorgulanıyor...';
            try {
                const formData = new FormData(barkodForm);
                const res = await fetch(barkodForm.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const data = await res.json();
                if (res.ok) {
                    barkodSonuc.innerHTML = `
                        <div class="p-2 bg-green-50 rounded">
                            <div><strong>Ad:</strong> ${data.ad || '-'}</div>
                            <div><strong>Fiyat:</strong> ${data.fiyat ?? '-'}</div>
                        </div>`;
                } else {
                    barkodSonuc.innerHTML = `<div class="p-2 bg-red-50 rounded">${data.error || 'Ürün bulunamadı'}</div>`;
                }
            } catch (err) {
                barkodSonuc.textContent = 'Sorgulama sırasında hata oluştu.';
            }
        });
    }
});
</script>
@endsection
