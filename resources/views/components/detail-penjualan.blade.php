@props(['order'])

<div class="modal fade" id="detailModal-{{ $order->id }}" tabindex="-1" aria-labelledby="detailModalLabel-{{ $order->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded shadow">
      <div class="modal-header">
        <h5 class="modal-title">Detail Penjualan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      @php
        $isMember = $order->customer && $order->customer->phone;
      @endphp

      <div class="modal-body">
        <div class="mb-3">
          <div class="row">
            <div class="col">
              <p class="mb-1">Member Status : {{ $isMember ? 'Member' : 'Non-Member' }}</p>
              <p class="mb-1">No. HP : {{ $isMember ? $order->customer->phone : '-' }}</p>
              <p class="mb-1">Poin Member : {{ $isMember ? $order->customer->points : '-' }}</p>
            </div>
            <div class="col text-end">
              <p class="col-md-9 ps-md-4">Bergabung Sejak : {{ $isMember ? $order->customer->created_at->translatedFormat('d F Y') : '-' }}</p>
            </div>
          </div>
        </div>
      
   
      
        <table class="table table-borderless text-center">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Qty</th>
              <th>Harga</th>
              <th>Sub Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->orderDetails as $item)
              <tr>
                <td>{{ $item->product->product_name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp. {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      
        <div class="text-end mt-3 fs-5">
          <strong>Total <span class="text-dark">Rp. {{ number_format($order->final_price, 0, ',', '.') }}</span></strong>
        </div>
      
        <div class="text-center text-muted small mt-2">
          Dibuat pada : {{ $order->created_at->format('Y-m-d H:i:s') }}<br>
          Oleh : Petugas
        </div>
      </div>      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
