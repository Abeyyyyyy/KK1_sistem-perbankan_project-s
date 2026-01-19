@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 3: Data Pembayaran dengan Vendor dan Metode Pembayaran</h2>
    </div>
    
    <div class="highlight">
        <strong>📌 Kalimat Informasi:</strong> Menampilkan data pembayaran beserta nama vendor dan metode pembayaran untuk invoice yang sudah dibayar.
    </div>
    
    <h3>✅ SQL JOIN:</h3>
    <div class="sql-box">
SELECT
    pembayaran.Pembayaran_ID,
    vendor.Nama_Vendor,
    pembayaran.Metode_Pembayaran,
    pembayaran.Tanggal_Bayar,
    pembayaran.Total_Bayar
FROM pembayaran
JOIN invoice
    ON pembayaran.Invoice_ID = invoice.Invoice_ID
JOIN vendor
    ON invoice.Vendor_ID = vendor.Vendor_ID;
    </div>
    
    <h3>✅ SQL Bertingkat (SUBQUERY):</h3>
    <div class="sql-box">
SELECT *
FROM pembayaran
WHERE Invoice_ID IN (
    SELECT Invoice_ID
    FROM invoice
);
    </div>
    
    <h3>🎯 Hasil Query (JOIN):</h3>
    <table>
        <thead>
            <tr>
                <th>ID Pembayaran</th>
                <th>Nama Vendor</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal Bayar</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $row)
            <tr>
                <td>PAY-{{ str_pad($row->Pembayaran_ID, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $row->Nama_Vendor }}</td>
                <td><span class="badge">{{ $row->Metode_Pembayaran }}</span></td>
                <td>{{ date('d/m/Y', strtotime($row->Tanggal_Bayar)) }}</td>
                <td style="color: #1A3D64; font-weight: bold;">
                    Rp {{ number_format($row->Total_Bayar, 0, ',', '.') }}
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