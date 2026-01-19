<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerbankanSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('invoice_petugas')->truncate();
        DB::table('pembayarans')->truncate();
        DB::table('items')->truncate();
        DB::table('petugas')->truncate();
        DB::table('invoices')->truncate();
        DB::table('vendors')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 1. Vendors (15 vendor)
        $vendors = [
            ['Nama_Vendor' => 'PT Sumber Makmur', 'Bank_Vendor' => 'BCA', 'No_Rekening' => '1234567890', 'NPWP' => '01.234.567.8-901.000'],
            ['Nama_Vendor' => 'CV Jaya Abadi', 'Bank_Vendor' => 'Mandiri', 'No_Rekening' => '9876543210', 'NPWP' => '02.345.678.9-012.000'],
            ['Nama_Vendor' => 'PT Teknologi Nusantara', 'Bank_Vendor' => 'BNI', 'No_Rekening' => '1122334455', 'NPWP' => '03.456.789.0-123.000'],
            ['Nama_Vendor' => 'UD Sejahtera Bersama', 'Bank_Vendor' => 'BRI', 'No_Rekening' => '3344556677', 'NPWP' => '04.567.890.1-234.000'],
            ['Nama_Vendor' => 'PT Mitra Usaha', 'Bank_Vendor' => 'BCA', 'No_Rekening' => '4455667788', 'NPWP' => '05.678.901.2-345.000'],
            ['Nama_Vendor' => 'CV Barokah', 'Bank_Vendor' => 'Mandiri', 'No_Rekening' => '5566778899', 'NPWP' => '06.789.012.3-456.000'],
            ['Nama_Vendor' => 'PT Anugerah Jaya', 'Bank_Vendor' => 'BNI', 'No_Rekening' => '6677889900', 'NPWP' => '07.890.123.4-567.000'],
            ['Nama_Vendor' => 'UD Mandiri Sejahtera', 'Bank_Vendor' => 'BRI', 'No_Rekening' => '7788990011', 'NPWP' => '08.901.234.5-678.000'],
            ['Nama_Vendor' => 'PT Multi Prima', 'Bank_Vendor' => 'BCA', 'No_Rekening' => '8899001122', 'NPWP' => '09.012.345.6-789.000'],
            ['Nama_Vendor' => 'CV Sinar Baru', 'Bank_Vendor' => 'Mandiri', 'No_Rekening' => '9900112233', 'NPWP' => '10.123.456.7-890.000'],
            ['Nama_Vendor' => 'PT Global Teknik', 'Bank_Vendor' => 'BNI', 'No_Rekening' => '1011121314', 'NPWP' => '11.234.567.8-901.000'],
            ['Nama_Vendor' => 'UD Lancar Jaya', 'Bank_Vendor' => 'BRI', 'No_Rekening' => '1112131415', 'NPWP' => '12.345.678.9-012.000'],
            ['Nama_Vendor' => 'PT Maju Terus', 'Bank_Vendor' => 'BCA', 'No_Rekening' => '1213141516', 'NPWP' => '13.456.789.0-123.000'],
            ['Nama_Vendor' => 'CV Cepat Sembuh', 'Bank_Vendor' => 'Mandiri', 'No_Rekening' => '1314151617', 'NPWP' => '14.567.890.1-234.000'],
            ['Nama_Vendor' => 'PT Sehat Selalu', 'Bank_Vendor' => 'BNI', 'No_Rekening' => '1415161718', 'NPWP' => '15.678.901.2-345.000'],
        ];
        DB::table('vendors')->insert($vendors);

        // 2. Invoices (20 invoice)
        $invoices = [];
        for ($i = 1; $i <= 20; $i++) {
            $vendorId = rand(1, 15);
            $totalTagihan = rand(1000000, 50000000);
            $invoices[] = [
                'Vendor_ID' => $vendorId,
                'No_Referensi' => 'INV-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'Tanggal_Dokumen' => date('Y-m-d', strtotime("2025-01-" . rand(1, 28))),
                'Deskripsi' => 'Invoice untuk pembelian barang/jasa ' . $i,
                'Total_Tagihan' => $totalTagihan,
            ];
        }
        DB::table('invoices')->insert($invoices);

        // 3. Petugas (10 petugas)
        $petugas = [
            ['Nama_Petugas' => 'Andi Saputra', 'Jabatan_Pegawai' => 'Staff Keuangan', 'Divisi_Pegawai' => 'Keuangan'],
            ['Nama_Petugas' => 'Budi Santoso', 'Jabatan_Pegawai' => 'Supervisor', 'Divisi_Pegawai' => 'Akuntansi'],
            ['Nama_Petugas' => 'Citra Lestari', 'Jabatan_Pegawai' => 'Manager', 'Divisi_Pegawai' => 'Keuangan'],
            ['Nama_Petugas' => 'Dedi Kurniawan', 'Jabatan_Pegawai' => 'Staff Administrasi', 'Divisi_Pegawai' => 'Administrasi'],
            ['Nama_Petugas' => 'Eka Wijaya', 'Jabatan_Pegawai' => 'Supervisor', 'Divisi_Pegawai' => 'Keuangan'],
            ['Nama_Petugas' => 'Fitri Anggraini', 'Jabatan_Pegawai' => 'Staff Akuntansi', 'Divisi_Pegawai' => 'Akuntansi'],
            ['Nama_Petugas' => 'Gunawan Pratama', 'Jabatan_Pegawai' => 'Manager', 'Divisi_Pegawai' => 'Akuntansi'],
            ['Nama_Petugas' => 'Hana Susanti', 'Jabatan_Pegawai' => 'Staff Keuangan', 'Divisi_Pegawai' => 'Keuangan'],
            ['Nama_Petugas' => 'Irfan Maulana', 'Jabatan_Pegawai' => 'Supervisor', 'Divisi_Pegawai' => 'Administrasi'],
            ['Nama_Petugas' => 'Joko Widodo', 'Jabatan_Pegawai' => 'Direktur', 'Divisi_Pegawai' => 'Direksi'],
        ];
        DB::table('petugas')->insert($petugas);

        // 4. Items (minimal 2-4 item per invoice, total 50+ item)
        $items = [];
        $itemNames = ['Kertas A4', 'Tinta Printer', 'Laptop', 'Monitor', 'Keyboard', 'Mouse', 'Kursi Kantor', 'Meja Kantor', 'AC', 'Printer', 'Scanner', 'Proyektor', 'Server', 'Router', 'Switch', 'Software Lisensi', 'Maintenance', 'Jasa Konsultan', 'Pengembangan Sistem', 'Pelatihan'];
        
        $itemId = 1;
        for ($invoiceId = 1; $invoiceId <= 20; $invoiceId++) {
            $numItems = rand(2, 4); // Setiap invoice punya 2-4 item
            for ($j = 1; $j <= $numItems; $j++) {
                $items[] = [
                    'Item_ID' => $itemId++,
                    'Invoice_ID' => $invoiceId,
                    'Nama_Item' => $itemNames[rand(0, count($itemNames)-1)],
                    'Nominal' => rand(500000, 5000000),
                    'Cost_Center' => 'CC' . str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT),
                ];
            }
        }
        DB::table('items')->insert($items);

        // 5. Invoice_Petugas (setiap invoice ditangani 1-3 petugas)
        $invoicePetugas = [];
        for ($invoiceId = 1; $invoiceId <= 20; $invoiceId++) {
            $numPetugas = rand(1, 3);
            $selectedPetugas = [];
            for ($p = 0; $p < $numPetugas; $p++) {
                $petugasId = rand(1, 10);
                // Pastikan tidak duplikat petugas untuk invoice yang sama
                while (in_array($petugasId, $selectedPetugas)) {
                    $petugasId = rand(1, 10);
                }
                $selectedPetugas[] = $petugasId;
                
                $roles = ['Pembuat Invoice', 'Pemeriksa Invoice', 'Penyetuju Invoice', 'Verifikator', 'Arsiparis'];
                $invoicePetugas[] = [
                    'Invoice_ID' => $invoiceId,
                    'Petugas_ID' => $petugasId,
                    'Peran' => $roles[rand(0, count($roles)-1)],
                ];
            }
        }
        DB::table('invoice_petugas')->insert($invoicePetugas);

        // 6. Pembayaran (semua invoice sudah dibayar)
        $pembayarans = [];
        $metodes = ['Transfer', 'Tunai', 'Cek', 'Giro', 'Kredit'];
        
        for ($invoiceId = 1; $invoiceId <= 20; $invoiceId++) {
            $invoice = DB::table('invoices')->where('Invoice_ID', $invoiceId)->first();
            $vendor = DB::table('vendors')->where('Vendor_ID', $invoice->Vendor_ID)->first();
            
            $pembayarans[] = [
                'Invoice_ID' => $invoiceId,
                'Metode_Pembayaran' => $metodes[rand(0, count($metodes)-1)],
                'Tanggal_Bayar' => date('Y-m-d', strtotime($invoice->Tanggal_Dokumen . ' +' . rand(5, 15) . ' days')),
                'Total_Bayar' => $invoice->Total_Tagihan,
                'Rekening_Tujuan' => $vendor->No_Rekening,
            ];
        }
        DB::table('pembayarans')->insert($pembayarans);
    }
}