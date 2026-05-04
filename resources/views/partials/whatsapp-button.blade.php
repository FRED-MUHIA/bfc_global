@php
    $whatsapp = $site['whatsapp'] ?? [];
    $whatsappPhone = preg_replace('/\D+/', '', $whatsapp['phone'] ?? '');
    $whatsappMessage = $whatsapp['message'] ?? '';
    $whatsappLabel = $whatsapp['label'] ?? 'Chat on WhatsApp';
    $whatsappUrl = $whatsappPhone
        ? 'https://wa.me/' . $whatsappPhone . ($whatsappMessage ? '?text=' . rawurlencode($whatsappMessage) : '')
        : null;
@endphp

@if (($whatsapp['enabled'] ?? false) && $whatsappUrl)
    <a
        href="{{ $whatsappUrl }}"
        target="_blank"
        rel="noopener"
        aria-label="{{ $whatsappLabel }}"
        title="{{ $whatsappLabel }}"
        class="fixed bottom-5 right-5 z-50 inline-flex items-center justify-center bg-[#25D366] text-white shadow-[0_12px_30px_rgba(17,94,57,0.35)] transition hover:scale-105 hover:bg-[#1fb85a] focus:outline-none focus:ring-4 focus:ring-[#25D366]/30"
        style="width: 64px; height: 64px; min-width: 64px; min-height: 64px; border-radius: 9999px; overflow: hidden; border: 4px solid rgba(255,255,255,0.9);"
    >
        <svg aria-hidden="true" viewBox="0 0 32 32" class="h-9 w-9 shrink-0 fill-current">
            <path d="M16.02 3.2A12.74 12.74 0 0 0 5.16 22.62L3.8 28.8l6.31-1.52A12.74 12.74 0 1 0 16.02 3.2Zm0 2.42a10.32 10.32 0 0 1 8.76 15.78 10.31 10.31 0 0 1-13.97 3.68l-.43-.24-3.54.85.76-3.46-.28-.45A10.32 10.32 0 0 1 16.02 5.62Zm-3.48 4.83c-.24 0-.62.08-.95.45-.32.36-1.25 1.22-1.25 2.98s1.28 3.45 1.46 3.69c.18.24 2.48 3.96 6.12 5.39 3.03 1.2 3.64.96 4.3.9.66-.06 2.13-.87 2.43-1.7.3-.84.3-1.56.21-1.71-.09-.15-.33-.24-.69-.42-.36-.18-2.13-1.05-2.46-1.17-.33-.12-.57-.18-.81.18-.24.36-.93 1.17-1.14 1.41-.21.24-.42.27-.78.09-.36-.18-1.52-.56-2.9-1.79-1.07-.95-1.8-2.13-2.01-2.49-.21-.36-.02-.55.16-.73.16-.16.36-.42.54-.63.18-.21.24-.36.36-.6.12-.24.06-.45-.03-.63-.09-.18-.81-1.95-1.11-2.67-.29-.7-.59-.6-.81-.61h-.66Z" />
        </svg>
        <span class="sr-only">{{ $whatsappLabel }}</span>
    </a>
@endif
