<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan Kerusakan Fasilitas</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #334155;
            margin: 20px;
            font-size: 14px;
            line-height: 1.5;
        }

        /* HEADER LAPORAN */
        .header-container {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        h2 {
            color: #0f172a;
            font-size: 22px;
            margin: 0 0 6px 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-info {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }

        .meta-info font {
            color: #1e293b;
            font-weight: bold;
        }

        /* STYLING TABEL */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #ffffff;
        }

        th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #cbd5e1;
            padding: 12px 10px;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            font-size: 13px;
            vertical-align: middle;
        }

        /* ALIGNMENT */
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        /* STATUS KETERANGAN */
        .status-badge {
            font-weight: bold;
            font-size: 12px;
        }

        .red {
            color: #dc2626;
        }

        .yellow {
            color: #d97706;
        }

        .green {
            color: #16a34a;
        }

        /* DATA KOSONG */
        .empty-row {
            padding: 30px;
            color: #94a3b8;
            font-style: italic;
            background-color: #f8fafc;
        }
    </style>
</head>

<body>

    <div class="header-container">
        <h2>Rekap Laporan Kerusakan Fasilitas</h2>
        <p class="meta-info">
            Periode Bulan: <font>{{ $bulan ? date('F', mktime(0, 0, 0, $bulan, 1)) : 'Semua Bulan' }}</font>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            Tahun: <font>{{ $tahun ?: 'Semua Tahun' }}</font>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 8%;">No</th>
                <th class="text-left" style="width: 32%;">Nama Fasilitas</th>
                <th class="text-left" style="width: 25%;">Lokasi</th>
                <th class="text-center" style="width: 15%;">Jumlah Lapor</th>
                <th class="text-center" style="width: 20%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekap as $y => $d)
                <tr>
                    <td class="text-center" style="color: #64748b;">{{ $y + 1 }}</td>
                    <td class="text-left" style="font-weight: 600; color: #0f172a;">{{ $d->nama_fasilitas }}</td>
                    <td class="text-left" style="color: #475569;">{{ $d->lokasi }}</td>
                    <td class="text-center" style="font-weight: bold; color: #1e293b;">{{ $d->jumlah_lapor }} Kali</td>
                    <td class="text-center">
                        @if ($d->jumlah_lapor >= 5)
                            <span class="status-badge red">Perlu Ganti Baru</span>
                        @elseif($d->jumlah_lapor >= 3)
                            <span class="status-badge yellow">Perlu Monitoring</span>
                        @else
                            <span class="status-badge green">Aman</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center empty-row">
                        Tidak ada data rekapitulasi laporan pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
