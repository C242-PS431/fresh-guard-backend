@extends('layout.base')

@section('title')
Scanner
@endsection

@section('content')
@include('partials.header')
<div class="flex flex-col justify-center items-center min-h-dvh w-full p-16">
    <div class="flex flex-col justify-center items-center w-1/2">
        {{-- Foto Profile user --}}
        <img id="profile-picture" src="https://gameranx.com/wp-content/uploads/2023/04/ayakatitel.jpg" alt="logo"
            class="w-32 h-32 rounded-lg">
        <p class="text-5xl font-semibold text-slate-300 mt-5">Selamat Datang <span
                class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-blue-500 to-purple-600"
                id="user-name">Ayaka</span>
        </p>
        <div class="stats shadow mt-10">

            <div class="stat">
                <div class="stat-figure text-secondary">

                </div>
                <div class="stat-title">Kalori</div>
                <div class="stat-value" id="calories">10 kkal</div>
                <div class="stat-desc text-green-600" id="caloriesPersen">↗︎ 22%</div>
            </div>

            <div class="stat">

                <div class="stat-title">Serat</div>
                <div class="stat-value" id="fiber">12 g</div>
                <div class="stat-desc text-green-600" id="fiberPersen">↗︎ 22%</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-secondary">

                </div>
                <div class="stat-title">Protein</div>
                <div class="stat-value" id="protein">14 g</div>
                <div class="stat-desc text-red-600" id="proteinPersen">↘︎ 14%</div>
            </div>
            <div class="stat">
                <div class="stat-figure text-secondary">

                </div>
                <div class="stat-title">Karbohidrat</div>
                <div class="stat-value" id="carbohydrates">4 g</div>
                <div class="stat-desc text-green-600" id="carbohydratesPersen">↗︎ 22%</div>
            </div>
        </div>
        <p class="text-lg font-semibold text-slate-300 mt-5">Keren, kamu telah mengkonsumsi <span
                class="underline text-green-500" id="maxNutriPersen">22%</span> lebih banyak <span class=" text-yellow-700" id="maxProduce">Serat 🥜</span>
            dibandingkan kemarin</p>

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

        <div class="flex justify-center items-center mt-10 gap-5">
            <a href="/scan" class="btn btn-primary text-center w-1/2">Scan sekarang</a>
            <a href="/user/history" class="btn btn-primary text-center w-1/2">Lihat riwayat lengkap</a>
        </div>
        <button id="logoutButton" class="btn btn-error text-center w-1/2 mt-10">Logout</button>

        <script>


            document.getElementById('logoutButton').addEventListener('click', async () => {
                try {
                    await window.axios.post('/api/auth/logout');
                    window.location.href = '/login';
                } catch (error) {
                    alert(error.response.data.message);
                    console.error('Logout failed', error);
                }
            });
        </script>
    </div>
</div>

<script>
    // load nama user dan user profile picture 
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const data = (await window.axios.get('/api/v1/profile', {})).data.data;
            document.getElementById('user-name').textContent = data.name;
            // jika user punya photo profile, maka load photo profile
            if (data.has_pfp) {
                const response = await window.axios.get('/api/v1/profile/picture', { responseType: 'blob' });
                const imageUrl = URL.createObjectURL(response.data);
                document.getElementById('profile-picture').src = imageUrl;
            }
            console.log("berhasil");
        } catch (e) {
        }
    });

    // load nutrisi harini and ananlysist
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const nutrition = (await window.axios.get('/api/v1/nutritions', {})).data.data;
            document.getElementById('fiber').textContent = `${nutrition.fiber} g`;
            document.getElementById('calories').textContent = `${nutrition.calories} kkal`;
            document.getElementById('protein').textContent = `${nutrition.protein} g`;
            document.getElementById('carbohydrates').textContent = `${nutrition.carbohydrates} g`;

            const yesterdayNutrition = (await window.axios.get('/api/v1/nutritions?date=yesterday', {})).data.data;
            const hitungPersentase = (nutrition, yesterdayNutrition) => Math.floor(nutrition / yesterdayNutrition * 100 - 100);

            const nutriPersenMap = new Map();
            nutriPersenMap.set('Serat', hitungPersentase(nutrition.fiber, yesterdayNutrition.fiber));
            nutriPersenMap.set('Kalori', hitungPersentase(nutrition.calories, yesterdayNutrition.calories));
            nutriPersenMap.set('Protein', hitungPersentase(nutrition.protein, yesterdayNutrition.protein));
            nutriPersenMap.set('Karbohidrat', hitungPersentase(nutrition.carbohydrates, yesterdayNutrition.carbohydrates));

            document.getElementById('fiberPersen').textContent = nutriPersenMap.get('Serat') + '%';
            document.getElementById('caloriesPersen').textContent = nutriPersenMap.get('Kalori') + '%';
            document.getElementById('proteinPersen').textContent = nutriPersenMap.get('Protein') + '%';
            document.getElementById('carbohydratesPersen').textContent = nutriPersenMap.get('Karbohidrat') + '%';

            function getKeyByValue(map, searchValue) {
                const entries = Array.from(map.entries());
                const foundEntry = entries.find(([key, value]) => value === searchValue);
                return foundEntry ? foundEntry[0] : undefined;
            }
            const maxNutriPersen = Math.max(...nutriPersenMap.values());
            const maxProduce = getKeyByValue(nutriPersenMap, maxNutriPersen);
            document.getElementById('maxNutriPersen').textContent = maxNutriPersen + "%";
            document.getElementById('maxProduce').textContent = `${maxProduce} 🥜`;
        } catch (e) {
            console.error(e);
        }
    });

    // load riwayat scan
    window.addEventListener('DOMContentLoaded', async () => {
        const parser = new DOMParser();
        const scanHistoryTbody = document.getElementById('scanHistoryTbody');
        const response = await window.axios.get('/api/v1/scans?date=today&per_page=3', {});
        for (let i = 0; i < Math.min(3, response.data.data.length); i++) {
            const scan = response.data.data[i];
            scanHistoryTbody.innerHTML += `@include('components.scan-result-row')`;
            const rowScan = scanHistoryTbody.lastElementChild;
            rowScan.querySelector('[name="scan-id"]').textContent = scan.id;
            rowScan.querySelector('[name="produce"]').textContent = scan.produce.name;
            rowScan.querySelector('[name="confidence"]').textContent = `${scan.freshness_score}%`;
            rowScan.querySelector('[name="scannedAt"]').textContent = scan.created_at;
            rowScan.querySelector('[name="condition"]').textContent = scan.freshness_score > 50 ? "Fresh" :
                "Rotten";
            rowScan.querySelector('[name="verifiedStore"]').textContent = (scan.verified_store) ?
                "Verified" : "Unverified";
        }

    });

    // fetchData();
</script>
@endsection