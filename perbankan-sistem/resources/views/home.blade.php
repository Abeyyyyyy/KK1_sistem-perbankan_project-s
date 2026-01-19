@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Selamat Datang di Sistem Perbankan</h2>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Total Vendor</div>
                <div class="stat-number">{{ $totalVendors }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Invoice</div>
                <div class="stat-number">{{ $totalInvoices }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Tagihan</div>
                <div class="stat-number">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Pembayaran</div>
                <div class="stat-number">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</div>
            </div>
        </div>

        <h3>Invoice Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>No. Referensi</th>
                    <th>Vendor</th>
                    <th>Tanggal</th>
                    <th>Total Tagihan</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentInvoices as $invoice)
                    <tr>
                        <td>{{ $invoice->No_Referensi }}</td>
                        <td>{{ $invoice->Nama_Vendor }}</td>
                        <td>{{ date('d/m/Y', strtotime($invoice->Tanggal_Dokumen)) }}</td>
                        <td>Rp {{ number_format($invoice->Total_Tagihan, 0, ',', '.') }}</td>
                        <td>{{ $invoice->Deskripsi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 3rem;">
            <h2>7 Query SQL yang Diimplementasikan</h2>

            <div class="query-grid">
                <!-- Query 1 -->
                <div class="query-card">
                    <h3>Query 1</h3>
                    <p><strong>Invoice dengan Total Tagihan > Rata-rata</strong></p>
                    <p>Menampilkan invoice yang nilai total tagihannya lebih besar dari rata-rata seluruh invoice.</p>
                    <a href="/query1" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 2 -->
                <div class="query-card">
                    <h3>Query 2</h3>
                    <p><strong>Invoice dengan > 1 Item</strong></p>
                    <p>Menampilkan invoice beserta jumlah item dan total nominal item, untuk invoice yang memiliki jumlah
                        item lebih dari satu.</p>
                    <a href="/query2" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 3 -->
                <div class="query-card">
                    <h3>Query 3</h3>
                    <p><strong>Data Pembayaran + Vendor</strong></p>
                    <p>Menampilkan data pembayaran beserta nama vendor dan metode pembayaran untuk invoice yang sudah
                        dibayar.</p>
                    <a href="/query3" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 4 -->
                <div class="query-card">
                    <h3>Query 4</h3>
                    <p><strong>Invoice + Petugas Terlibat</strong></p>
                    <p>Menampilkan invoice beserta nama petugas yang terlibat, untuk invoice yang ditangani oleh lebih dari
                        satu petugas.</p>
                    <a href="/query4" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 5 -->
                <div class="query-card">
                    <h3>Query 5</h3>
                    <p><strong>Vendor dengan Total Tagihan Terbesar</strong></p>
                    <p>Menampilkan vendor beserta total seluruh tagihan invoice yang dimilikinya, untuk vendor dengan total
                        tagihan terbesar.</p>
                    <a href="/query5" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 6 -->
                <div class="query-card">
                    <h3>Query 6</h3>
                    <p><strong>Petugas Divisi Keuangan dengan Peran</strong></p>
                    <p>Menampilkan nama petugas dari divisi Keuangan beserta peran yang mereka jalankan dalam penanganan
                        invoice.</p>
                    <a href="/query6" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 7 -->
                <div class="query-card">
                    <h3>Query 7</h3>
                    <p><strong>Vendor yang Menjual Item "Printer"</strong></p>
                    <p>Menampilkan daftar vendor yang menjual item dengan nama "printer" beserta informasi bank dan nomor
                        rekening mereka.</p>
                    <a href="/query7" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 8 -->
                <div class="query-card">
                    <h3>Query 8</h3>
                    <p><strong>Invoice vs Total Nilai Item</strong></p>
                    <p>Menampilkan informasi invoice beserta total nilai item, untuk mengetahui total nominal seluruh item
                        pada setiap invoice dan membandingkannya dengan total tagihan invoice.</p>
                    <a href="/query8" class="btn">Lihat Hasil</a>
                </div>

                <!-- Query 9 -->
                <div class="query-card">
                    <h3>Query 9</h3>
                    <p><strong>Beban Kerja Petugas</strong></p>
                    <p>Menampilkan informasi petugas beserta jumlah invoice yang ditangani, untuk mengetahui beban kerja
                        setiap petugas berdasarkan jumlah invoice yang menjadi tanggung jawabnya.</p>
                    <a href="/query9" class="btn">Lihat Hasil</a>
                </div>

            </div>
        </div>
    </div>
@endsection