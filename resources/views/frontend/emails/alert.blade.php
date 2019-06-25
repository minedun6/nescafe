{{ $alerte->created_at ? $alerte->created_at->format('d-m-Y') : '' }}<br>
<p>
    {!! $alerte->message != '' ? strip_tags($alerte->message) : '' !!}
</p>