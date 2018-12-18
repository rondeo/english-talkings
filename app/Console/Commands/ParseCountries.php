<?php

namespace App\Console\Commands;

use App\Country;
use App\Language;
use GuzzleHttp\Client;
use Illuminate\Console\Command;


class ParseCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parser for countries';

    private $apiUrl = 'https://restcountries.eu/rest/v2/all';

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
        $countryList = $this->getCountriesList($this->apiUrl);

        $path = public_path('svg/flags/');

        if (!empty($countryList) && !is_dir($path)) {
            mkdir($path,0777, true);
        }

        $this->saveLanguages($countryList);
        $this->saveCountries($countryList);
    }

    private function getCountriesList($url)
    {
        $client = new Client();
        $res = $client->get($this->apiUrl, ['verify' => false]);

        if($res->getStatusCode() != 200) {
            $this->error("Can't get data from remote API");
        }

        $countryList = json_decode($res->getBody(), true);

        return $countryList;
    }

    private function saveLanguages(array $data)
    {
        foreach ($data as $item) {
            $exists = Language::where('name', $item['languages'][0]['name'])->first();
            if (is_null($exists)) {
                try {
                    $language = new Language();
                    $language->name = $item['languages'][0]['name'];
                    $language->save();
                    $this->info($item['languages'][0]['name']);
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }
    }

    private function saveCountries(array $data)
    {
        foreach ($data as $item) {
            $language = Language::where('name', $item['languages'][0]['name'])->first();

            $filename = $item['name'] . '.svg';

            try {
                $this->saveFlagSvg($filename, $item['flag']);

                $country = new Country();
                $country->name = $item['name'];
                $country->flag = 'svg/flags/' . $filename;
                $country->geojson = json_encode('{}');
                $country->language_id = $language->id;
                $country->save();

                $this->info($item['name']);

            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
    }

    private function saveFlagSvg(string $filename, $url)
    {
        try {
            file_put_contents(
                public_path('svg/flags/' . $filename),
                file_get_contents($url)
            );
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
