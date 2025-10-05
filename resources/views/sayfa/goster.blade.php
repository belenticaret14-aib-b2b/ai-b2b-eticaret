@extends('layouts.app')

@section('title', $sayfa->meta_baslik ?? $sayfa->baslik)
@section('meta_description', $sayfa->meta_aciklama)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-8">
            {!! $sayfa->icerik !!}
        </div>
    </div>
</div>

<!-- İletişim formu için özel JavaScript -->
@if($sayfa->slug === 'iletisim')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="/iletisim"]');
    if (form) {
        // CSRF token ekle
        const tokenInput = form.querySelector('input[name="_token"]');
        if (tokenInput) {
            tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
        
        // Form gönderimi için AJAX
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            fetch('{{ route("sayfa.iletisim.gonder") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Mesajınız başarıyla gönderildi!');
                    form.reset();
                } else {
                    alert('Hata: ' + (data.message || 'Bilinmeyen hata'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
        });
    }
});
</script>
@endif
@endsection