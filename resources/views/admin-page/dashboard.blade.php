<x-layouts>

    <div class="pagetitle">
      <h1>Halaman Dashboard</h1>
         <nav>
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">Dashboard</a></li>
                 <li class="breadcrumb-item active">Dashboard admin</li>
             </ol>
         </nav>
     </div>
  
    <section class="section">
      <div class="row">
  
        @php
          $barLabels = $salesPerDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray();
          $barData = $salesPerDay->pluck('total_orders')->toArray();
  
          $pieLabels = $productsSold->pluck('product_name')->toArray();
          $pieData = $productsSold->pluck('total_qty')->toArray();
        @endphp
  
        <!-- Bar Chart -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bar Chart - Jumlah Transaksi per Hari</h5>
  
              <canvas id="barChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#barChart'), {
                    type: 'bar',
                    data: {
                      labels: @json($barLabels),
                      datasets: [{
                        label: 'Jumlah Transaksi',
                        data: @json($barData),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true,
                          title: {
                            display: true,
                            text: 'Jumlah Transaksi'
                          }
                        },
                        x: {
                          title: {
                            display: true,
                            text: 'Tanggal'
                          }
                        }
                      }
                    }
                  });
                });
              </script>
  
            </div>
          </div>
        </div>
  
        <!-- Pie Chart -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Pie Chart - Persentase Produk Terjual</h5>
  
              <canvas id="pieChart" style="max-height: 270px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#pieChart'), {
                    type: 'pie',
                    data: {
                      labels: @json($pieLabels),
                      datasets: [{
                        label: 'Produk Terjual',
                        data: @json($pieData),
                        backgroundColor: [
                          'rgb(255, 99, 132)',
                          'rgb(54, 162, 235)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
                          'rgb(153, 102, 255)',
                          'rgb(255, 159, 64)',
                          'rgb(201, 203, 207)'
                        ],
                        hoverOffset: 4
                      }]
                    }
                  });
                });
              </script>
  
            </div>
          </div>
        </div>
  
      </div>
    </section>
  </x-layout>
  