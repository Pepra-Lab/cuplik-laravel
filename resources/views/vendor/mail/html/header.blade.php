@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel' || trim($slot) === config('app.name'))
    <span>Cuplik<span class="brand-dot">.</span><span class="brand-green">com</span></span>
    <span class="tagline">{{ trim($slot) === config('app.name') ? 'Notifikasi' : $slot }}</span>
@else
    {{ $slot }}
@endif
</a>
</td>
</tr>
