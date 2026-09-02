@props(['url'])

<tr>
    <td align="center" style="padding: 30px 0 25px;">
        <a href="{{ $url }}"
           style="
               display: inline-block;
               text-decoration: none;
               font-family: Arial, Helvetica, sans-serif;
               font-size: 24px;
               font-weight: 700;
               color: #0f172a;
           ">
            {{ config('app.name') }}
        </a>
    </td>
</tr>