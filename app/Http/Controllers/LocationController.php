<?php

namespace App\Http\Controllers;


/**
 * Class LocationController
 * Handles region, province, city, and barangay endpoints.
 */
class LocationController extends Controller
{
    private const NOT_FOUND_MESSAGE = 'Not Found';

    private function getData($fileName)
    {
        $cacheKey = "location_data_{$fileName}";
        if (\Cache::has($cacheKey)) {
            return \Cache::get($cacheKey);
        }

        $filePath = storage_path("app/public/{$fileName}.json");
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $data = json_decode(file_get_contents($filePath), true);
        \Cache::put($cacheKey, $data, now()->addHours(24)); // Cache for 24 hours
        return $data;
    }

    /**
     * Retrieve all regions.
     *
     * @return \Illuminate\Http\Response The response containing all region data.
     */
    public function getRegions()
    {
        return response()->json($this->getData('region'));
    }

    /**
     * Retrieve all provinces.
     *
     * @return \Illuminate\Http\Response The response containing all province data.
     */
    public function getProvinces()
    {
        return response()->json($this->getData('province'));
    }

    /**
     * Retrieve all cities.
     *
     * @return \Illuminate\Http\Response The response containing all city data.
     */
    public function getCities()
    {
        return response()->json($this->getData('city'));
    }

    /**
     * Retrieve all barangays.
     *
     * @return \Illuminate\Http\Response The response containing all barangay data.
     */
    public function getBarangays()
    {
        return response()->json($this->getData('barangay'));
    }


    /**
     * Retrieve the region based on the provided PSGC code.
     *
     * @param string $psgc_code The PSGC code of the region to retrieve.
     * @return \Illuminate\Http\Response The response containing the region data.
     */
    public function getRegionByCode($psgc_code)
    {
        $data = collect($this->getData('region'))->firstWhere('psgc_code', $psgc_code);
        return response()->json($data ?? ['message' => self::NOT_FOUND_MESSAGE], $data ? 200 : 404);
    }

    /**
     * Retrieve a single province based on the province code.
     *
     * @param string $province_code The code of the province to retrieve.
     * @return \Illuminate\Http\Response The response containing the province data.
     */
    public function getProvinceByCode($province_code)
    {
        $data = collect($this->getData('province'))->firstWhere('province_code', $province_code);
        return response()->json($data ?? ['message' => self::NOT_FOUND_MESSAGE], $data ? 200 : 404);
    }

    /**
     * Retrieve a single city based on the city code.
     *
     * @param string $city_code The code of the city to retrieve.
     * @return \Illuminate\Http\Response The response containing the city data.
     */
    public function getCityByCode($city_code)
    {
        $data = collect($this->getData('city'))->firstWhere('city_code', $city_code);
        return response()->json($data ?? ['message' => self::NOT_FOUND_MESSAGE], $data ? 200 : 404);
    }

    /**
     * Retrieve a single barangay by barangay code.
     *
     * @param string $brgy_code Barangay code.
     * @return \Illuminate\Http\Response The response containing the barangay data or a not found response.
     */
    public function getBarangayByCode($brgy_code)
    {
        $data = collect($this->getData('barangay'))->firstWhere('brgy_code', $brgy_code);
        return response()->json($data ?? ['message' => self::NOT_FOUND_MESSAGE], $data ? 200 : 404);
    }
}
