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
            if (strtolower($date) == 'today') {
                $date = Date::today('Asia/Jakarta');
            } else {
                $date = Date::createFromFormat('d-m-Y', $date, 'Asia/Jakarta');
            }
        } catch (\Exception $e) {
            $date = null;
        }

        /** @var \App\Models\ScanResult */
        $builder = $request->user()->scanResults()->with('produce')->orderByDesc('created_at');
        if (!is_null($date)) {
            // Hitung awal dan akhir hari dalam UTC+0 dari UTC+7
            $startOfDayUtc = $date->copy()->startOfDay()->setTimezone('UTC')->format('Y-m-d H:i:s');
            $endOfDayUtc = $date->copy()->endOfDay()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $builder->whereBetween('created_at', [$startOfDayUtc, $endOfDayUtc]);
        }
        if ($isGetTracked) {
            $builder->where('is_tracked', true);
        }

        $scanResults = $builder->paginate(perPage: $perPage, page: $page);
        return new ScanResultCollection($scanResults);
    }

    public function getUserNutiritionByDate(Request $request)
    {
        $date = null;
        try {
            $date = $request->query('date');
            if($date == 'yesterday'){
                $date = Date::yesterday('Asia/Jakarta');
            } else {
                $date = Date::createFromFormat('d-m-Y', $date, 'Asia/Jakarta');
            }
        } catch (\Exception $e) {
            $date = Date::today('Asia/Jakarta');
        }


        $startOfDayJakarta = $date->copy()->startOfDay()->setTimezone('UTC')->format('Y-m-d H:i:s');
        $endOfDayJakarta = $date->copy()->endOfDay()->setTimezone('UTC')->format('Y-m-d H:i:s');

        /**
         * @var \Illuminate\Database\Eloquent\Collection<\App\Models\ScanResult>
         */
        $scanResults = $request->user()
            ->scanResults()
            ->with('produce')
            ->whereBetween('created_at', [$startOfDayJakarta, $endOfDayJakarta])
            ->orderByDesc('created_at')
            ->get();

        

        $nutirtions = $scanResults->reduce(function ($carry, $scanResult) {
            return [
                'calories' => $carry['calories'] + $scanResult->produce->calories,
                'protein' => $carry['protein'] + $scanResult->produce->protein,
                'carbohydrates' => $carry['carbohydrates'] + $scanResult->produce->carbohydrates,
                'fiber' => $carry['fiber'] + $scanResult->produce->fiber
            ];
        }, [
            'calories' => 0,
            'protein' => 0,
            'carbohydrates' => 0,
            'fiber' => 0
        ]);

        // ini buat mengubah satuan nutrisi boey, dari miligram ke gram
        $nutirtions['protein'] = ($nutirtions['protein'] / 1000);
        $nutirtions['carbohydrates'] = $nutirtions['carbohydrates'] / 1000;
        $nutirtions['fiber'] = $nutirtions['fiber'] / 1000;

        return response()->json([
            'status' => 'success',
            'message' => 'kalori dalam satuan kkl dan yang lainnya dalam satuan gram',
            'data' => $nutirtions
        ]);
    }
}
