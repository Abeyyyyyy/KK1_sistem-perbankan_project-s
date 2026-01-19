@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 2: Invoice dengan Lebih dari 1 Item</h2>
    </div>
    
    <h3>SQL Query:</h3>
    <div class="sql-box">{{ $sql }}</div>
    
    <h3>Hasil Query:</h3>
    <table>
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Tanggal Dokumen</th>
                <th>Jumlah Item</th>
                <th>Total Nominal Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $row)
            <tr>
                <td>INV-{{ str_pad($row->Invoice_ID, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ date('d/m/Y', strtotime($row->Tanggal_Dokumen)) }}</td>
                <td><span style="background-color: #1D546C; color: white; padding: 4px 8px; border-radius: 4px;">{{ $row->Jumlah_Item }} item</span></td>
                <td style="color: #0C2B4E; font-weight: bold;">Rp {{ number_format($row->Total_Nominal_Item, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">← Kembali ke Home</a>
    </div>
</div>
@endsection