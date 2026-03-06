<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #111; }
        .header { width: 100%; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 14px; }
        .logo-box { width: 86px; height: 86px; border: 1px solid #000; text-align: center; font-size: 10pt; vertical-align: middle; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        .center { text-align: center; }
        .title { font-size: 18pt; font-weight: bold; text-transform: uppercase; line-height: 1.15; }
        .sub { font-size: 11pt; line-height: 1.3; }
        .doc-title { text-align: center; font-weight: bold; text-decoration: underline; font-size: 16pt; margin-top: 10px; }
        .doc-no { text-align: center; margin-top: 2px; margin-bottom: 14px; font-size: 14pt; }
        .paragraph { text-align: justify; line-height: 1.45; margin-bottom: 10px; }
        .identitas { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .identitas td { padding: 1px 0; vertical-align: top; }
        .id-no { width: 24px; }
        .id-key { width: 130px; }
        .id-sep { width: 15px; }
        .asset-table { width: 100%; border-collapse: collapse; margin: 10px 0 14px; }
        .asset-table th, .asset-table td { border: 1px solid #000; padding: 6px; }
        .asset-table th { text-align: center; }
        .sign { width: 100%; margin-top: 24px; border-collapse: collapse; }
        .sign td { width: 50%; text-align: center; vertical-align: top; }
        .spacer { height: 72px; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
@php
    $hari = [
        0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
        4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu',
    ];
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
    ];

    $tanggalBa = $beritaAcara->tanggal_ba;
    $tanggalKembali = $pengembalian->tanggal_kembali;

    $formatTanggal = function ($date) use ($hari, $bulan) {
        if (! $date) {
            return '-';
        }
        return sprintf(
            '%s, %02d %s %d',
            $hari[$date->dayOfWeek] ?? '-',
            $date->day,
            $bulan[$date->month] ?? '-',
            $date->year
        );
    };

    $rupiah = function ($nominal) {
        if ($nominal === null) {
            return '-';
        }
        return 'Rp ' . number_format((float) $nominal, 0, ',', '.');
    };

    $pihakPertama = $beritaAcara->ditandatangani_oleh ?: ($verifier->name ?? 'PIHAK PERTAMA');
    $pihakKedua = $pegawai->name ?? 'PIHAK KEDUA';
@endphp

<table class="header-table header">
    <tr>
        <td style="width: 95px;">
            <div class="logo-box">LOGO</div>
        </td>
        <td class="center">
            <div class="title">Pemerintah Kabupaten Bengkalis<br>Dinas Pendidikan</div>
            <div class="sub">
                Jalan Pertanian Nomor : 012 Bengkalis Kode Pos 28714<br>
                Telepon : 0821-6976-5430 Fax (0766) 8001009 E-Mail : bengkalisdisdik884@gmail.com<br>
                Website : www.disdik.bengkaliskab.go.id
            </div>
        </td>
    </tr>
</table>

<div class="doc-title">BERITA ACARA SERAH TERIMA ASET</div>
<div class="doc-no">Nomor : {{ $beritaAcara->nomor_ba }}</div>

<div class="paragraph">
    Pada hari ini {{ strtolower($formatTanggal($tanggalBa)) }}, yang bertandatangan di bawah ini:
</div>

<table class="identitas">
    <tr><td class="id-no">1.</td><td class="id-key">Nama</td><td class="id-sep">:</td><td class="bold">{{ strtoupper($pihakPertama) }}</td></tr>
    <tr><td></td><td>Jabatan</td><td>:</td><td>Pihak yang menerima aset</td></tr>
    <tr><td></td><td>Instansi</td><td>:</td><td>Dinas Pendidikan Kabupaten Bengkalis, selanjutnya disebut <span class="bold">PIHAK PERTAMA</span></td></tr>
</table>

<table class="identitas">
    <tr><td class="id-no">2.</td><td class="id-key">Nama</td><td class="id-sep">:</td><td class="bold">{{ strtoupper($pihakKedua) }}</td></tr>
    <tr><td></td><td>Jabatan</td><td>:</td><td>Peminjam/Penyerah aset</td></tr>
    <tr><td></td><td>Instansi</td><td>:</td><td>Dinas Pendidikan Kabupaten Bengkalis, selanjutnya disebut <span class="bold">PIHAK KEDUA</span></td></tr>
</table>

<div class="paragraph">
    <span class="bold">PIHAK KEDUA</span> telah menyerahkan kepada <span class="bold">PIHAK PERTAMA</span> barang inventaris
    dalam keadaan <span class="bold">{{ strtoupper($pengembalian->kondisi_saat_kembali) }}</span>, dengan rincian sebagai berikut:
</div>

<table class="asset-table">
    <thead>
        <tr>
            <th style="width: 50px;">No</th>
            <th>Jenis Barang</th>
            <th>Merk / Type</th>
            <th>Asal Pengadaan</th>
            <th>Harga Perolehan (Rp)</th>
            <th style="width: 100px;">Jumlah Barang</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="center">1</td>
            <td>{{ strtoupper($aset->nama) }}</td>
            <td>{{ $aset->keterangan ?: '-' }}</td>
            <td>{{ $aset->tanggal_perolehan ? 'APBD ' . $aset->tanggal_perolehan->format('Y') : 'APBD -' }}</td>
            <td>{{ $rupiah($aset->nilai_perolehan) }}</td>
            <td class="center">1 Unit</td>
        </tr>
    </tbody>
</table>

<div class="paragraph">
    Dengan ditandatanganinya berita acara ini, maka beralihlah hak dan tanggung jawab terhadap pemakaian
    dan pemeliharaan barang inventaris tersebut kepada <span class="bold">PIHAK PERTAMA</span>. Dokumen ini dibuat
    rangkap 2 (dua) untuk dipergunakan sebagaimana mestinya.
</div>

<div class="paragraph">
    Bengkalis, {{ $tanggalKembali ? sprintf('%02d %s %d', $tanggalKembali->day, $bulan[$tanggalKembali->month] ?? '-', $tanggalKembali->year) : '-' }}
</div>

<table class="sign">
    <tr>
        <td>
            <div class="bold">PIHAK KEDUA</div>
            <div>Yang Menyerahkan,</div>
            <div class="spacer"></div>
            <div class="bold">{{ strtoupper($pihakKedua) }}</div>
        </td>
        <td>
            <div class="bold">PIHAK PERTAMA</div>
            <div>Yang Menerima Penyerahan,</div>
            <div class="spacer"></div>
            <div class="bold">{{ strtoupper($pihakPertama) }}</div>
        </td>
    </tr>
</table>

</body>
</html>
