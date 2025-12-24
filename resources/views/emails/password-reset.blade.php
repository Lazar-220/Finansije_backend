<x-mail::message>
# Zdravo, {{$user->name}}

Dobijena je molba za reset lozinke.

Klikni na dugme ispod da nastavis proces resetovanja lozinke.

<x-mail::button :url="'$resetUrl'">
Resetuj lozinku
</x-mail::button>

Tvoj token za reset lozinke je:

**{{$token}}**

Ako niste podneli zahtev za reset lozinke, slobodno ignorisite ovu poruku.

Hvala,<br>
{{ config('app.name') }}
</x-mail::message>
