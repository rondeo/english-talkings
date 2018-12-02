<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountriesController extends Controller
{
    public function index()
    {
        return Country::orderBy('name')->get();
    }

    protected function transformData($geojson)
    {
        $str = '[';

        foreach ($geojson as $item) {
            $str .= (string)$item['geojson'].",\n";
        }

        $geoData = substr($str,0,-1);
        $geoData = substr($geoData,0,-1);

        $geoData .= ']';

        return $geoData;
    }

    public function geoJson() {
        $geojson = Country::select('geojson',  DB::raw('count(country_id) as users'))
            ->join('users', 'countries.id', '=', 'users.country_id')
            ->where('geojson', 'NOT LIKE', '%null%')
            ->groupBy('geojson')
            ->orderBy('users', 'DESC')
            ->get();

        $count = count($geojson);
        $offset = floor($count/3);
        $secondOffset = $offset + $offset;

        $str = '[';
        foreach ($geojson as $key => $item) {
            if ($key < $offset) {
                $str .= (string)$item['geojson'] . ",\n";
            }
        }
        $redData = substr($str,0,-1);
        $redData = substr($redData,0,-1);
        $redData .= ']';

        $str = '[';
        foreach ($geojson as $key => $item) {
            if ($key >= $offset && $key < $secondOffset) {
                $str .= (string)$item['geojson'] . ",\n";
            }
        }
        $yellowData = substr($str,0,-1);
        $yellowData = substr($yellowData,0,-1);
        $yellowData .= ']';

        $str = '[';
        foreach ($geojson as $key => $item) {
            if ($key >= $secondOffset) {
                $str .= (string)$item['geojson'] . ",\n";
            }
        }
        $greenData = substr($str,0,-1);
        $greenData = substr($greenData,0,-1);
        $greenData .= ']';


        return view('welcome', compact('greenData', 'yellowData', 'redData'));
    }
}
