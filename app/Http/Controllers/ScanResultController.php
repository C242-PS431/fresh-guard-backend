<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScanResultCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ScanResultController extends Controller
{
    public function getScanResults(Request $request): ScanResultCollection
    {
        $perPage = $request->integer('per_page', 5);
        $page = $request->integer('page', 1);
        $isGetTracked = $request->boolean('get_tracked', false);
        try {
            $date = $request->query('date');
            if(strtolower($date) == 'today'){
                $date = Date::today();
            } else {
                $date = Date::createFromFormat('d-m-Y', $date, 'Asia/Jakarta');
            }
        } catch (\Exception $e) {
            $date = null;
        }

        $builder = $request->user()->scanResults()->orderBy('created_at');
        if (!is_null($date)) {
            // Hitung awal dan akhir hari dalam UTC+0
            $startOfDayUtc = $date->copy()->startOfDay()->setTimezone('UTC')->format('Y-m-d H:i:s');
            $endOfDayUtc = $date->copy()->endOfDay()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $builder->whereBetween('created_at', [$startOfDayUtc, $endOfDayUtc]);
        }
        if($isGetTracked){
            $builder->where('is_tracked', true);
        }

        $scanResults = $builder->paginate(perPage: $perPage, page: $page);
        return new ScanResultCollection($scanResults);
    }
}
