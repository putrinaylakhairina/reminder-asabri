<x-mail::message>
# Halo {{ $pensioner->nama }},

Kami ingin menginformasikan bahwa pembayaran dana pensiun Anda akan segera jatuh tempo.

**Detail Informasi:**
- **Nama:** {{ $pensioner->nama }}
- **NIP:** {{ $pensioner->nip }}
- **Tanggal Jatuh Tempo:** {{ $pensioner->tanggal_jatuh_tempo->format('d F Y') }}
- **Status:** {{ $pensioner->status_label }}

Silakan lakukan pengecekan atau tindakan yang diperlukan agar pembayaran dana pensiun Anda berjalan lancar.

Terima kasih,<br>
Sistem Pengingat ASABRI
</x-mail::message>
