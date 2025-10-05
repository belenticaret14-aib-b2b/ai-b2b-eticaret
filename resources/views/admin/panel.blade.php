@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Yönetici Paneli</h1>

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
    <h2 class="h5 mb-3">İstatistikler</h2>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted">Ürün</div>
                            <div class="h4">{{ $istatistik['urun'] }}</div>
                        </div>
                        <span class="badge text-bg-primary">Toplam</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted">Bayi</div>
                            <div class="h4">{{ $istatistik['bayi'] }}</div>
                        </div>
                        <span class="badge text-bg-success">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted">Mağaza</div>
                            <div class="h4">{{ $istatistik['magaza'] }}</div>
                        </div>
                        <span class="badge text-bg-secondary">Bağlı</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endisset

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.urun.index') }}" class="btn btn-outline-primary btn-sm">Ürünler</a>
        <a href="{{ route('admin.urun.create') }}" class="btn btn-primary btn-sm">Yeni Ürün</a>
        <a href="{{ route('admin.magaza.create') }}" class="btn btn-outline-secondary btn-sm">Mağaza Ekle</a>
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
