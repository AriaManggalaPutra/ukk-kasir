<?php

namespace App\Exports;

use App\Models\OrderDetail\OrderDetail;
use App\Models\Pembelian\Pembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $date;
    protected $day;
    protected $month;
    protected $year;
    protected $filterType;

    public function __construct($date = null, $day = null, $month = null, $year = null, $filterType = null)
    {
        $this->date = $date;
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->filterType = $filterType;
    }

    public function collection()
    {
        $query = Pembelian::with(['customer', 'orderDetails.product'])
            ->orderBy('created_at', 'desc');

        // Sesuaikan dengan filter yang aktif
        if ($this->filterType === 'date' && $this->date) {
            $query->whereDate('created_at', $this->date);
        } elseif ($this->filterType === 'day' && $this->day) {
            $query->whereDay('created_at', $this->day);
        } elseif ($this->filterType === 'month' && $this->month) {
            $query->whereMonth('created_at', $this->month);
        } elseif ($this->filterType === 'year' && $this->year) {
            $query->whereYear('created_at', $this->year);
        }

        return $query->get();
    }

    public function map($order): array
    {
        $produk = $order->orderDetails->map(function ($detail) {
            if (!$detail->product) {
                return 'Produk tidak ditemukan';
            }
        
            return $detail->product->product_name . 
                   ' (' . $detail->quantity . ' x Rp ' . 
                   number_format($detail->product->price, 0, ',', '.') . 
                   ' = Rp ' . number_format($detail->subtotal, 0, ',', '.') . ')';
        })->implode("\n");

        return [
            $order->customer->name ?? 'Non-member',
            $order->customer->phone ?? '-',
            $order->customer->points ?? '0',
            $produk,
            'Rp ' . number_format($order->total_price, 0, ',', '.'),
            'Rp ' . number_format($order->amount_paid, 0, ',', '.'),
            'Rp ' . number_format($order->discount ?? 0, 0, ',', '.'),
            'Rp ' . number_format($order->change, 0, ',', '.'),
            $order->created_at->format('d-m-Y H:i:s'),
            $order->createdBy->name ?? 'System',
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Produk (Qty x Harga = Subtotal)',
            'Total Harga',
            'Total Bayar',
            'Total Diskon',
            'Total Kembalian',
            'Tanggal Pembelian',
            'Dibuat Oleh'
        ];
    }
}