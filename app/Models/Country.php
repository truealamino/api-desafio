<?php

namespace App\Models;

use App\Enums\FilterSearchEnum;
use App\Enums\ResponseEnum;
use Facades\App\Repository\Countries;
use GuzzleHttp\Client;

class Country
{
    protected $client = null;
    protected $headers = null;
    protected $queryFields = null;

    public function __construct($options = [])
    {
        $this->setClientRequest($options);
    }

    public function setClientRequest($options = [])
    {
        $base_uri = isset($options['base_uri']) ? $options['base_uri'] : env("BASE_URI");
        $this->client = new Client(['base_uri' => $base_uri]);

        $this->headers = isset($options['headers']) ? $options['headers'] : ['Content-type' => 'application/x-www-form-urlencoded'];

        $this->queryFields = isset($options['queryFields']) ? "?fields=" . $options['queryFields'] : "?fields=name;flag;alpha3Code;population;timezones;currencies;languages;capital;regionalBlocs;borders;region";
    }

    public function getClientRequest()
    {
        return [
            "client" => $this->client,
            "headers" => $this->headers,
            "queryFields" => $this->queryFields
        ];
    }

    public function getCountries($data)
    {
        $clientRequest = $this->getClientRequest();
        $type = null;
        $term = isset($data['term']) ? $data['term'] : null;
        $items = [];

        if (isset($data['typeSearch'])) {
            switch ($data['typeSearch']) {
                case FilterSearchEnum::all:
                    $type = "all";
                    $items = Countries::getItems($type, $term, $clientRequest);
                    break;
                case FilterSearchEnum::byName:
                    $type = "name/";
                    $items = Countries::getItems($type, $term, $clientRequest);
                    break;
                case FilterSearchEnum::byCode:
                    $items = [$this->showCountry($term)];
                    break;
                case FilterSearchEnum::byCurrencies:
                    $type = "currency/";
                    $items = Countries::getItems($type, $term, $clientRequest);
                    break;

                default:
                    $type = "all";
                    break;
            }

            return [
                'ret' => ResponseEnum::successResponse,
                'msg' => 'Busca realizada com sucesso!',
                'data' => $items,
                'codeResponse' => 200
            ];
        } else {
            return ['ret' => ResponseEnum::failedResponse, 'msg' => 'É necessário definir um tipo de filtro para a pesquisa.', "data" => [], 'codeResponse' => 500];
        }
    }

    public function showCountry($term = '')
    {
        $clientRequest = $this->getClientRequest();
        $item = Countries::showItem($term, $clientRequest);

        return $item;
    }

    public function getByRegion($region)
    {
        $clientRequest = $this->getClientRequest();
        $items = Countries::getByRegion($region, $clientRequest);

        return $items;
    }
}
