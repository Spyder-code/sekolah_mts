@component('mail::message')
    <strong>
        Assalamu'alaikum warahmatullahi wabarakatuh
    </strong>
    <br><br>
    Berikut informasi seputar nilai yang baru diselesaikan:
    <br><br>
    1. Nama: {{ $data['nama'] }} <br>
    2. Kelas: {{ $data['kelas'] }} <br>
    3. Mata Pelajaran: {{ $data['mapel'] }} <br>
    4. Kategori: {{ $data['kategori'] }} <br>
    5. Waktu: {{ $data['waktu'] }} <br>
    6. Nilai: {{ $data['nilai'] }} <br>
    <br>
    Demikiam informasi nilai yang dapat kami sampaikan <br>
    Kami ucapkan terima kasih
    <br><br>
    Wassalamu'alaikum warahmatullahi wabarakatuh
@endcomponent
