@extends('layouts.app')

@section('title', 'Ödeme - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">💳 Ödeme</h1>
            <p class="text-gray-600">Sipariş bilgilerinizi kontrol edin ve ödeme yönteminizi seçin</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('odeme.islem') }}" method="POST" x-data="odemeForm()">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sol: Sipariş Özeti -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">📦 Sipariş Özeti</h2>
                        
                        <!-- Ürünler -->
                        <div class="space-y-4 mb-6">
                            @foreach($sepet['items'] as $item)
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    @if($item['gorsel'])
                                        <img src="{{ asset('storage/' . $item['gorsel']) }}" alt="{{ $item['ad'] }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <i class="fas fa-box text-gray-400 text-2xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $item['ad'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item['adet'] }} adet</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">₺{{ number_format($item['fiyat'] * $item['adet'], 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Tutarlar -->
                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ara Toplam:</span>
                                <span class="font-medium">₺{{ number_format($sepet['total'], 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Kargo:</span>
                                <span class="font-medium" x-text="kargoTutari"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">KDV (%18):</span>
                                <span class="font-medium" x-text="vergiTutari"></span>
                            </div>
                            <div class="border-t border-gray-200 pt-2">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Toplam:</span>
                                    <span class="text-blue-600" x-text="toplamTutar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sağ: Ödeme Formu -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Teslimat Bilgileri -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">📍 Teslimat Bilgileri</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ad Soyad *</label>
                                <input type="text" name="teslimat_bilgileri[ad_soyad]" 
                                       value="{{ $kullanici->ad ?? '' }} {{ $kullanici->soyad ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telefon *</label>
                                <input type="tel" name="teslimat_bilgileri[telefon]" 
                                       value="{{ $kullanici->telefon ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">E-posta *</label>
                                <input type="email" name="teslimat_bilgileri[email]" 
                                       value="{{ $kullanici->email ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Posta Kodu</label>
                                <input type="text" name="teslimat_bilgileri[posta_kodu]" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adres *</label>
                                <textarea name="teslimat_bilgileri[adres]" rows="3" 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Şehir *</label>
                                <select name="teslimat_bilgileri[sehir]" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="">Şehir Seçin</option>
                                    <option value="İstanbul">İstanbul</option>
                                    <option value="Ankara">Ankara</option>
                                    <option value="İzmir">İzmir</option>
                                    <option value="Bursa">Bursa</option>
                                    <option value="Antalya">Antalya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">İlçe *</label>
                                <input type="text" name="teslimat_bilgileri[ilce]" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Ödeme Yöntemi -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">💳 Ödeme Yöntemi</h2>
                        
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="odeme_yontemi" value="kredi_karti" class="mr-3" required>
                                <div class="flex items-center">
                                    <i class="fas fa-credit-card text-blue-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Kredi/Banka Kartı</p>
                                        <p class="text-sm text-gray-600">Visa, MasterCard, American Express</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="odeme_yontemi" value="banka_havalesi" class="mr-3" required>
                                <div class="flex items-center">
                                    <i class="fas fa-university text-green-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Banka Havalesi</p>
                                        <p class="text-sm text-gray-600">EFT/HAVALE ile ödeme</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="odeme_yontemi" value="kapida_odeme" class="mr-3" required>
                                <div class="flex items-center">
                                    <i class="fas fa-hand-holding-usd text-orange-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Kapıda Ödeme</p>
                                        <p class="text-sm text-gray-600">Kargo ile nakit ödeme (+₺5)</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Sipariş Notları -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">📝 Sipariş Notları</h2>
                        <textarea name="notlar" rows="4" 
                                  placeholder="Siparişinizle ilgili özel notlarınızı buraya yazabilirsiniz..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <!-- Ödeme Butonu -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-lock mr-3"></i>
                            <span>Siparişi Tamamla ve Öde</span>
                            <span class="ml-2 text-lg" x-text="toplamTutar"></span>
                        </button>
                        
                        <p class="text-xs text-gray-500 text-center mt-4">
                            🔒 Güvenli ödeme sistemi ile korunuyorsunuz
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function odemeForm() {
    const sepetTotal = {{ $sepet['total'] }};
    
    return {
        kargoTutari: '₺' + (sepetTotal >= 500 ? '0' : sepetTotal >= 200 ? '15' : '25'),
        get vergiTutari() {
            return '₺' + (sepetTotal * 0.18).toFixed(2);
        },
        get toplamTutar() {
            const kargo = sepetTotal >= 500 ? 0 : sepetTotal >= 200 ? 15 : 25;
            const vergi = sepetTotal * 0.18;
            return '₺' + (sepetTotal + kargo + vergi).toFixed(2);
        }
    }
}
</script>
@endsection



