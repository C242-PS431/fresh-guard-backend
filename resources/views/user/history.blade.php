@extends('layout.base')

@section('title')
Scanner
@endsection

@section('content')
@include('partials.header')
<div class="flex flex-col justify-center items-center min-h-dvh w-full p-16">
    <p class="text-lg font-semibold text-slate-300 mb-2 mt-10">Riwayat Hasil Scan</p>
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>

                        <th>Food</th>
                        <th>Fresh Confidence</th>
                        <th>Verified shop</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="scanHistoryTbody">
                </tbody>

            </table>
        </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', async () => {
        const parser = new DOMParser();
        const scanHistoryTbody = document.getElementById('scanHistoryTbody');
        const data = await window.axios.get('/api/v1/scans?per_page=50');
        for (scan of data.data.data) {
            scanHistoryTbody.innerHTML += `@include('components.scan-result-row')`;
            const rowScan = scanHistoryTbody.lastElementChild 
            rowScan.querySelector('[name="scan-id"]').textContent = scan.id;
            rowScan.querySelector('[name="produce"]').textContent = scan.produce.name;
            rowScan.querySelector('[name="confidence"]').textContent = `${scan.freshness_score}%`;
            rowScan.querySelector('[name="scannedAt"]').textContent = scan.created_at;
            rowScan.querySelector('[name="condition"]').textContent = scan.freshness_score > 50 ? "Fresh" : "Rotten";
            rowScan.querySelector('[name="verifiedStore"]').textContent = (scan.verified_store) ? "Verfied" : "Unverified";
        }
    });

    // fetchData();
</script>
@endsection