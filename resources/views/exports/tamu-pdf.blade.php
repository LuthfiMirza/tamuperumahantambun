<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Tamu - {{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 16px;
            font-weight: normal;
        }
        
        .info {
            margin-bottom: 20px;
            font-size: 11px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }
        
        .status-dalam {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-keluar {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .jenis-badge {
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .jenis-warga {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .jenis-ojek {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .jenis-kurir {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .jenis-lainnya {
            background-color: #F3F4F6;
            color: #374151;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA TAMU</h1>
        <h2>{{ $title }}</h2>
    </div>
    
    <div class="info">
        <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB<br>
        <strong>Total Data:</strong> {{ $tamus->count() }} tamu<br>
        @if($filter === 'today')
            <strong>Filter:</strong> Data Hari Ini ({{ \Carbon\Carbon::today('Asia/Jakarta')->format('d/m/Y') }})
        @else
            <strong>Filter:</strong> Semua Data
        @endif
    </div>
    
    @if($tamus->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Jenis Tamu</th>
                    <th style="width: 12%;">Plat Nomor</th>
                    <th style="width: 10%;">Tanggal</th>
                    <th style="width: 10%;">Jam Masuk</th>
                    <th style="width: 10%;">Jam Keluar</th>
                    <th style="width: 12%;">Status</th>
                    <th style="width: 26%;">Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tamus as $index => $tamu)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <span class="jenis-badge 
                            @if(strtolower($tamu->jenis_tamu) == 'tamu warga') jenis-warga
                            @elseif(strtolower($tamu->jenis_tamu) == 'ojek online') jenis-ojek
                            @elseif(strtolower($tamu->jenis_tamu) == 'kurir') jenis-kurir
                            @else jenis-lainnya
                            @endif">
                            {{ $tamu->jenis_tamu }}
                        </span>
                    </td>
                    <td>{{ $tamu->plat_nomor ?: '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($tamu->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $tamu->jam_masuk }}</td>
                    <td>{{ $tamu->jam_keluar ?: '-' }}</td>
                    <td>
                        <span class="status-badge {{ strtolower($tamu->posisi) == 'sedang didalam' ? 'status-dalam' : 'status-keluar' }}">
                            {{ strtolower($tamu->posisi) == 'sedang didalam' ? 'Di Dalam' : 'Sudah Keluar' }}
                        </span>
                    </td>
                    <td>{{ $tamu->tujuan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            Tidak ada data tamu untuk ditampilkan
        </div>
    @endif
    
    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name }} (Satpam)</p>
        <p>Sistem Manajemen Tamu - {{ date('Y') }}</p>
    </div>
</body>
</html>