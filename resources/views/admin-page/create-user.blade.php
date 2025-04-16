<x-layouts>

    <div class="pagetitle">
        <h1>Tambah Pengguna</h1>
           <nav>
               <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="{{route('data-user')}}">List Pengguna</a></li>
                   <li class="breadcrumb-item active">Tambah Pengguna</li>
               </ol>
           </nav>
       </div>
               
           <div class="card shadow-sm border-0 rounded-lg"> 
               <div class="card-body p-4"> 
                   <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
                       @csrf
       
                    
                       
                       <div class="mb-3">
                           <label for="name" class="form-label">Nama</label>
                           <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                           @error('name') <small class="text-danger">{{$message}}</small> @enderror
                       </div>
    
                       <div class="mb-3">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}">
                           @error('email') <small class="text-danger">{{$message}}</small> @enderror
                       </div>
       
                       
                       <div class="mb-3">
                           <label for="password" class="form-label">Kata Sandi</label>
                           <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}">
                           @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                       </div>
    
                    <div class="mb-3">
                        <label for="role" class="form-label">Peran</label>
                        <div class="input-group">
                            <select class="form-select" name="role">
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
                        </div>
                    </div>
                
           
                       <button type="submit" class="btn btn-primary">Simpan</button>
                   </form>
               </div>
           </div>
       </x-layouts>
       
       
       
       
       
       