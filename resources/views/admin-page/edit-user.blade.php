<x-layouts>

    <div class="pagetitle">
        <h1>Edit Produk</h1>
           <nav>
               <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="{{route('data-user')}}">Daftar Pengguna</a></li>
                   <li class="breadcrumb-item active">Edit Produk</li>
               </ol>
           </nav>
       </div>
               
           <div class="card shadow-sm border-0 rounded-lg"> 
               <div class="card-body p-4"> 
                   <form action="{{Route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                       @csrf
                        @method('PUT')
    
                       
                       <div class="mb-3">
                           <label for="name" class="form-label">Nama</label>
                           <input type="text" class="form-control" name="name" id="name" value="{{old('name', $user->name)}}">
                           @error('name') <small class="text-danger">{{$message}}</small> @enderror
                       </div>

                       <div class="mb-3">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" name="email" id="email" value="{{old('email', $user->email)}}">
                           @error('email') <small class="text-danger">{{$message}}</small> @enderror
                       </div>
       
                       <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" name="password" id="password">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                       </div>
    
                    <div class="mb-3">
                        <label for="role" class="form-label">Peran</label>
                        <div class="input-group">
                            <select class="form-select" name="role" id="role">
                                <option value="admin"{{old('role', $user->role)== 'admin' ? 'selected' : ''}}>Admin</option>
                                <option value="petugas"{{old('role', $user->role)== 'petugas' ? 'selected' : ''}}>Petugas</option>
                            </select>
                        </div>
                    </div>
                
           
                       <button type="submit" class="btn btn-primary">Simpan</button>
                   </form>
               </div>
           </div>
       </x-layouts>
       
       
       
       
       
       