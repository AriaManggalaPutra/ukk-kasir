<x-layouts>
    <div class="pagetitle">
        <h1>Halaman Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('data-user') }}">Pengguna</a></li>
                <li class="breadcrumb-item active">Daftar Pengguna</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-1">
            <div class="container mt-4">
                <x-add-button route="user.create" buttonText="Tambah Pengguna" />

                <div class="table-responsive">
                    <table class="table table-striped align-middle w-100" style="table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 30%;">Nama</th>
                                <th style="width: 30%;">Email</th>
                                <th style="width: 15%;">Role</th>
                                <th style="width: 20%;" class="text-end"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'success' }}">{{ ucfirst($user->role) }}</span></td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                            <!-- Tombol Hapus hanya ditampilkan jika role pengguna 'petugas' -->
                                            @if($user->role == 'petugas')
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}">
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-user.modal-delete></x-user.modal-delete>
</x-layouts>
