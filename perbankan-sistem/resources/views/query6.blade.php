@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 6: Petugas Divisi Keuangan dengan Peran Mereka</h2>
    </div>
    
    <div class="highlight">
        <strong>📌 Kalimat Informasi:</strong> Menampilkan nama petugas dari divisi Keuangan beserta peran yang mereka jalankan dalam penanganan invoice.
    </div>
    
    <div class="stats" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-label">Total Petugas Keuangan</div>
            <div class="stat-number">{{ $total_petugas_keuangan }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Peran</div>
            <div class="stat-number">{{ count($roles_count) }}</div>
        </div>
    </div>
    
    <h3>✅ SQL JOIN:</h3>
    <div class="sql-box">
SELECT p.Nama_Petugas, ip.Peran
FROM petugas p
JOIN invoice_petugas ip ON p.Petugas_ID = ip.Petugas_ID
WHERE p.Divisi_Pegawai = 'Keuangan';
    </div>
    
    <h3>🎯 Hasil Query JOIN:</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Petugas</th>
                <th>Peran</th>
                <th>Divisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results_join as $row)
            <tr>
                <td>{{ $row->Nama_Petugas }}</td>
                <td><span class="badge">{{ $row->Peran }}</span></td>
                <td><span style="color: #1D546C; font-weight: bold;">Keuangan</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>✅ SQL Bertingkat (SUBQUERY):</h3>
    <div class="sql-box">
SELECT 
    (SELECT Nama_Petugas FROM petugas WHERE Petugas_ID = ip.Petugas_ID) AS Nama_Petugas,
    ip.Peran
FROM invoice_petugas ip
WHERE ip.Petugas_ID IN (
    SELECT Petugas_ID 
    FROM petugas 
    WHERE Divisi_Pegawai = 'Keuangan'
);
    </div>
    
    <h3>🎯 Hasil Query SUBQUERY:</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Petugas</th>
                <th>Peran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results_subquery as $row)
            <tr>
                <td>{{ $row->Nama_Petugas }}</td>
                <td><span class="badge">{{ $row->Peran }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>📊 Distribusi Peran Petugas Keuangan:</h3>
    <table>
        <thead>
            <tr>
                <th>Peran</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles_count as $role)
            <tr>
                <td>{{ $role->Peran }}</td>
                <td>{{ $role->jumlah }}</td>
                <td>
                    <div style="background-color: #e0e0e0; border-radius: 4px; height: 20px; margin: 5px 0;">
                        @php
                            $percentage = ($total_petugas_keuangan > 0) ? round(($role->jumlah / $total_petugas_keuangan) * 100, 1) : 0;
                        @endphp
                        <div style="background-color: #1D546C; height: 100%; width: {{ $percentage }}%; border-radius: 4px;"></div>
                    </div>
                    {{ $percentage }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">🏠 Kembali ke Home</a>
    </div>
</div>
@endsection