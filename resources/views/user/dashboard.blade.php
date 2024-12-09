@extends('layout.base')

@section('title')
    Scanner
@endsection

@section('content')
    @include('partials.header')
    <div class="flex flex-col justify-center items-center min-h-dvh w-full p-16">
        <div class="flex flex-col justify-center items-center w-1/2">
            {{-- Foto Profile user --}}
            <img src="{{ url('https://gameranx.com/wp-content/uploads/2023/04/ayakatitel.jpg') }}" alt="logo"
                class="w-32 h-32 rounded-lg">
            <p class="text-5xl font-semibold text-slate-300 mt-5">Selamat Datang <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-blue-500 to-purple-600">Ayaka</span>
            </p>
            <div class="stats shadow mt-10">
                <div class="stat">

                    <div class="stat-title">Serat</div>
                    <div class="stat-value">12 g</div>
                    <div class="stat-desc text-green-600">↗︎ 22%</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">

                    </div>
                    <div class="stat-title">Kalori</div>
                    <div class="stat-value">10 kkal</div>
                    <div class="stat-desc text-green-600">↗︎ 22%</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">

                    </div>
                    <div class="stat-title">Protein</div>
                    <div class="stat-value">14 g</div>
                    <div class="stat-desc text-red-600">↘︎ 14%</div>
                </div>
                <div class="stat">
                    <div class="stat-figure text-secondary">

                    </div>
                    <div class="stat-title">Karbohidrat</div>
                    <div class="stat-value">4 g</div>
                    <div class="stat-desc text-green-600">↗︎ 22%</div>
                </div>
            </div>
            <p class="text-lg font-semibold text-slate-300 mt-5">Keren, kamu telah mengkonsumsi <span
                    class="underline text-green-500">22%</span> lebih banyak <span class=" text-yellow-700">Serat 🥜</span>
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
                    <tbody>
                        <!-- row 1 -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img src="https://minnetonkaorchards.com/wp-content/uploads/2021/04/Bright-Red-Apple.jpg"
                                                alt="Avatar Tailwind CSS Component" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">Apple</div>
                                        <div class="text-sm opacity-50">28/02/2024</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                52.49%
                                <br />
                                <span class="badge badge-ghost badge-sm text-green-600">Fresh</span>
                            </td>
                            <td>Verified</td>
                            <th>
                                <button class="btn btn-ghost btn-xs">details</button>
                            </th>
                        </tr>
                        <!-- row 2 -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img src="https://minnetonkaorchards.com/wp-content/uploads/2021/04/Bright-Red-Apple.jpg"
                                                alt="Avatar Tailwind CSS Component" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">Apple</div>
                                        <div class="text-sm opacity-50">28/02/2024</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                12.49%
                                <br />
                                <span class="badge badge-ghost badge-sm text-red-600">Rotten</span>
                            </td>
                            <td>Verified</td>
                            <th>
                                <button class="btn btn-ghost btn-xs">details</button>
                            </th>
                        </tr>
                        <!-- row 3 -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img src="https://minnetonkaorchards.com/wp-content/uploads/2021/04/Bright-Red-Apple.jpg"
                                                alt="Avatar Tailwind CSS Component" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">Apple</div>
                                        <div class="text-sm opacity-50">28/02/2024</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                52.49%
                                <br />
                                <span class="badge badge-ghost badge-sm text-green-600">Fresh</span>
                            </td>
                            <td>Verified</td>
                            <th>
                                <button class="btn btn-ghost btn-xs">details</button>
                            </th>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
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
