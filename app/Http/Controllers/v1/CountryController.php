<?php

namespace App\Http\Controllers\v1;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = $request->all();

            $country = new Country();

            $countries = $country->getCountries($data);

            return response()->json(['ret' => $countries['ret'], 'msg' => $countries['msg'], 'data' => $countries['data']], $countries['codeResponse']);
        } catch (Exception $e) {
            return response()->json(['ret' => ResponseEnum::failedResponse, 'msg' => "Erro ao buscar países!", 'erro' => $e->getMessage()]);
        }
    }

    public function show($code)
    {
        try {
            $countryIns = new Country();

            $country = $countryIns->showCountry($code);

            return response()->json(['ret' => ResponseEnum::successResponse, 'msg' => 'País encontrado com sucesso!', 'data' => $country], 200);
        } catch (Exception $e) {
            return response()->json(['ret' => ResponseEnum::failedResponse, 'msg' => "Erro ao buscar país!", 'erro' => $e->getMessage()]);
        }
    }

    public function getBordersByCountry(Request $request)
    {
        $data = $request->all();

        try {
            if (isset($data['borders'])) {
                $options = [
                    "queryFields" => "alpha3Code;name&codes=" . $data['borders']
                ];

                $countryIns = new Country($options);
                $items = $countryIns->showCountry();
            }

            return response()->json(['ret' => ResponseEnum::successResponse, 'msg' => 'Países da fronteira encontrados com sucesso!', 'data' => $items], 200);
        } catch (Exception $e) {
            return response()->json(['ret' => ResponseEnum::failedResponse, 'msg' => "Erro ao buscar países da fronteira!", 'erro' => $e->getMessage()]);
        }
    }

    public function getCountriesByRegion(Request $request)
    {
        try {
            $data = $request->all();
            $options = [
                "queryFields" => "alpha3Code;name;borders"
            ];

            $countryIns = new Country($options);

            $items = $countryIns->getByRegion($data['region']);

            return response()->json(['ret' => ResponseEnum::successResponse, 'msg' => 'Países do continente encontrados com sucesso!', 'data' => $items], 200);
        } catch (Exception $e) {
            return response()->json(['ret' => ResponseEnum::failedResponse, 'msg' => "Erro ao buscar países do continente!", 'erro' => $e->getMessage()]);
        }
    }
}
