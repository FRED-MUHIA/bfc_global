@php
    $typeLabel = str($type)->replace('_', ' ')->title();
@endphp

<div style="font-family: Arial, sans-serif; color: #24342d; line-height: 1.7;">
    <p style="font-size: 12px; letter-spacing: 0.12em; text-transform: uppercase; color: #b98d28; font-weight: 700;">{{ $typeLabel }}</p>
    <div>{!! nl2br(e($body)) !!}</div>
    <p style="margin-top: 28px; color: #5f6d65;">BFC Global Trust</p>
</div>
