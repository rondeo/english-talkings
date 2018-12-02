<?php

namespace App\Console\Commands;

use App\Country;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ParseGeoJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:geojson';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add geojson to countries table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $res = $client->get('https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json', ['verify' => false]);

        if($res->getStatusCode() != 200) {
            $this->error("Can't get data from remote url");
        }

        $geoJson = json_decode($res->getBody(), true);
        foreach ($geoJson['features'] as $item) {
            $country = Country::where('name', $item['properties']['name'])->first();
            if($country) {
               $country->geojson = json_encode($item);
               $country->save();
           }
        }
    }
}
