@extends('layout.base')

@section('title')
    Scanner
    
@endsection

@section('content')
    @include('partials.header')
    <div class="flex flex-col justify-center items-center h-dvh w-full p-16">
       <div class="w-full border-2 border-dashed p-5">
              <form method="POST" enctype="multipart/form-data" class=" flex flex-col gap-10">
                @csrf
                <input type="file" name="file" id="file" class="file-input file-input-bordered w-full max-w-xs">
                <div class="w-1/4">
                    <p>Bau dari buah</p>
                    <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Busuk</span>
                          <input type="radio" name="radio-1" class="radio checked:bg-red-500" checked="checked" />
                        </label>
                      </div>
                      <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Netral</span>
                          <input type="radio" name="radio-1" class="radio checked:bg-white" checked="checked" />
                        </label>
                      </div>
                      <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Segar</span>
                          <input type="radio" name="radio-1" class="radio checked:bg-blue-500" checked="checked" />
                        </label>
                      </div>
                </div>
                <div class="w-1/4">
                    <p>Tekstur dari buah</p>
                    <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Lembek</span>
                          <input type="radio" name="radio-2" class="radio checked:bg-red-500" checked="checked" />
                        </label>
                      </div>
                      <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Normal</span>
                          <input type="radio" name="radio-2" class="radio checked:bg-white" checked="checked" />
                        </label>
                      </div>
                      <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Keras</span>
                          <input type="radio" name="radio-2" class="radio checked:bg-blue-500" checked="checked" />
                        </label>
                      </div>
                </div>
                <div class="w-1/4">
                    <p>Apakah dari toko yang tervalidasi</p>
                    <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Tidak</span>
                          <input type="radio" name="radio-3" class="radio checked:bg-red-500" checked="checked" />
                        </label>
                      </div>
                      <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text">Ya</span>
                          <input type="radio" name="radio-3" class="radio checked:bg-blue-500" checked="checked" />
                        </label>
                      </div>
                </div>
                <button type="submit" class="btn btn-primary w-64 self-center">Scan</button>
              </form>
       </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            
            try {
                const response = await fetch('{{ url('api/v1/scans/freshness') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer 1|fHYPvgflpH0AEr2q8QVSSek6e7tMWisLAFlGupOl51467cb1'

                    }
                });
                
                const result = await response.json();
                console.log(result.json());
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>

@endsection