<tr>
<td>
<table class="footer" align="center" width="100%" cellpadding="0" cellspacing="0">
<tr>
<td class="content-cell" align="center">
{{ Illuminate\Mail\Markdown::parse($slot) }}
<p>
    &copy; {{ date('Y') }} Cuplik.com &middot;
    <a href="{{ route('info.redaksi') }}">Redaksi</a> &middot;
    <a href="{{ route('info.pedoman') }}">Pedoman Media</a> &middot;
    <a href="{{ route('info.disclaimer') }}">Disclaimer</a>
</p>
<p>Email ini dikirim otomatis, mohon tidak membalas langsung ke alamat ini.</p>
</td>
</tr>
</table>
</td>
</tr>
