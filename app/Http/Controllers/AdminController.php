<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\OrderDetail\OrderDetail;
use App\Models\Pembelian\Pembelian;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;





class AdminController extends Controller
{
    public function dashboard()
    {
  // Penjualan per hari
  $salesPerDay = Pembelian::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total_orders'))
  ->groupBy('date')
  ->orderBy('date', 'ASC')
  ->get();


  // Produk terjual (join ke tabel products)
  $productsSold = OrderDetail::join('products', 'order_details.product_id', '=', 'products.id')
      ->select('products.product_name', DB::raw('SUM(order_details.quantity) as total_qty'))
      ->groupBy('products.product_name')
      ->get();

  return view('admin-page.dashboard', [
      'salesPerDay' => $salesPerDay,
      'productsSold' => $productsSold
  ]);    }

    public function product()
    {
        $products = Product::all();
        return view('admin-page.product', compact('products'));    
    }


    public function createProduct()
    {
        return view('admin-page.create-product');
    }

    public function productStore(Request $request)
    {
        $validated = $request->validate([
            'product_name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $validated['product_image'] = $request->file('product_image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin-product')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {

        $products = Product::findOrFail($id);
        return view('admin-page.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {

        // dd($request);
        $request->merge([
            'price' => str_replace(['Rp.', '.', ' '], '', $request->price),
        ]);
    
        // Validasi
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $product = Product::findOrFail($id);
    
        if ($request->hasFile('product_image')) {
            $validated['product_image'] = $request->file('product_image')->store('products', 'public');
        }
    
        // Update data produk
        $product->update($validated);
    
        return redirect()->route('admin-product')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin-product')->with('status', 'Produk berhasil dihapus.');
    }

    public function user()
    {
        $users = User::latest()->get();
        return view('admin-page.user', compact('users'));
    }

    public function userCreate(Request $request)
    {
        return view ('admin-page.create-user');
    }

    public function userStore(Request $request)
    {
        
            $request->validate([
                'name'     => 'required',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:6',
                'role'     => 'required|in:admin,petugas',
            ]);
    
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);
    
            return redirect()->route('data-user')->with('success', 'User berhasil ditambahkan.');
        
    }
    public function edituser($id)
    {
        $user = User::findOrFail($id);
        return view('admin-page.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,petugas'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role
        ]);
        return redirect()->route('data-user')->with('success', 'User berhasil diupdate');
    }

    public function destroyUser($id)
    {
        $user = User::findorFail($id);
        $user->delete();
        return redirect()->route('data-user')->with('success', 'User berhasil dihapus!');
    }

    public function index(Request $request)
    {
        $query = Pembelian::with('customer', 'user')->latest();
    
        // Filter berdasarkan tanggal spesifik
        if ($request->filter_type === 'date' && $request->date) {
            $query->whereDate('created_at', $request->date);
        }
        // Filter berdasarkan hari
        elseif ($request->filter_type === 'day' && $request->day) {
            $query->whereDay('created_at', $request->day);
        }
        // Filter berdasarkan bulan
        elseif ($request->filter_type === 'month' && $request->month) {
            $query->whereMonth('created_at', $request->month);
        }
        // Filter berdasarkan tahun
        elseif ($request->filter_type === 'year' && $request->year) {
            $query->whereYear('created_at', $request->year);
        }
    
        $orders = $query->get();
    
        if (auth()->user()->role == 'admin') {
            return view('admin-page.penjualan', compact('orders'));
        } else {
            return view('petugas.pembelian.index', compact('orders'));
        }
    }

    public function print($id)
    {
        $order = Pembelian::with(['customer', 'orderDetails.product', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('admin-page.receipt-pdf', compact('order'))->setPaper('A5');

        // Nama file yang ingin di-download
        $fileName = "receipt-{$order->id}.pdf";

        // Mengunduh langsung ke device
        return $pdf->download($fileName);
    }

    public function exportPenjualan(Request $request)
{
    $filterType = $request->input('filter_type');
    $date = $request->input('date');
    $day = $request->input('day');
    $month = $request->input('month');
    $year = $request->input('year');
    
    $filename = 'laporan-penjualan';
    
    // Set filename berdasarkan filter
    if ($filterType === 'date' && $date) {
        $filename .= '-tanggal-' . $date;
    } elseif ($filterType === 'day' && $day) {
        $filename .= '-hari-' . $day;
    } elseif ($filterType === 'month' && $month) {
        $filename .= '-bulan-' . $month;
    } elseif ($filterType === 'year' && $year) {
        $filename .= '-tahun-' . $year;
    }
    
    $filename .= '.xlsx';
    
    return Excel::download(new PenjualanExport($date, $day, $month, $year, $filterType), $filename);
}
    


}
