@extends('layout.base')

@section('title')
Scanner

@endsection

@section('content')
@include('partials.header')

<div class="flex flex-col justify-center items-center h-dvh w-full p-16">
  <div class="w-full border-2 border-dashed p-5">
    <form enctype="multipart/form-data" id="form-scan" class=" flex flex-col gap-10">
      <input type="file" name="image" id="image" class="file-input file-input-bordered w-full max-w-xs">
      <div class="w-1/4">
        <p>Bau dari buah</p>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Busuk</span>
            <input type="radio" name="smell" value="rotten" class="radio checked:bg-red-500" />
          </label>
        </div>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Netral</span>
            <input type="radio" name="smell" value="neautral" class="radio checked:bg-white" checked="checked"/>
          </label>
        </div>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Segar</span>
            <input type="radio" name="smell" value="fresh" class="radio checked:bg-blue-500" />
          </label>
        </div>
      </div>
      <div class="w-1/4">
        <p>Tekstur dari buah</p>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Lembek</span>
            <input type="radio" name="texture" value="soft" class="radio checked:bg-red-500" />
          </label>
        </div>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Normal</span>
            <input type="radio" name="texture" value="normal" class="radio checked:bg-white" checked="checked"/>
          </label>
        </div>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Keras</span>
            <input type="radio" name="texture" value="hard" class="radio checked:bg-blue-500" />
          </label>
        </div>
      </div>
      <div class="w-1/4">
        <p>Apakah dari toko yang tervalidasi</p>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Tidak</span>
            <input type="radio" name="verified_store" value="false" class="radio checked:bg-red-500" />
          </label>
        </div>
        <div class="form-control">
          <label class="label cursor-pointer">
            <span class="label-text">Ya</span>
            <input type="radio" name="verified_store" value="true" class="radio checked:bg-blue-500" checked="checked"/>
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-64 self-center">Scan</button>
    </form>
  </div>
</div>

<script>
  document.getElementById('form-scan').addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    for (let [key, value] of formData.entries()) {
      console.log(`${key}: ${value}`);
    }

    try {
      const response = await window.axios.post('/api/v1/scans/freshness', formData, {
        withCredentials: true,
        headers: {
          "Accept": 'application/json',
        }
      });

      const result = await response.data;
      alert(JSON.stringify(result.data.scan_result));
      console.log(result);
    } catch (e) {
      console.log(e)
    }
  });
</script>

@endsection