<?php

namespace Drupal\material\Controller;

use Drupal\Core\Controller\ControllerBase;


class MaterialWeather extends ControllerBase {

    public function showWeather() {
        $items = [];
        $city = [];
        try {
            $client = \Drupal::httpClient();
            $request = $client->get('https://www.metaweather.com/api/location/44418/');
            $response = $request->getBody()->getContents();
            $london_data = json_decode($response, true);
            $items = isset($london_data['consolidated_weather']) ? $london_data['consolidated_weather'] : [];
            $city = isset($london_data['title']) ? $london_data['title'] : [];
        }
        catch (\Exception $e) {
            return [
                '#type' => 'markup',
                '#markup' => $e->getMessage(),
            ];
        }
        $render_array = [
            '#theme' => 'material_weather',
            '#items' => $items,
            '#city' => $city,
            '#cache' => [
                'max-age' => 0
            ],
            '#attached' => [
              'library' => [
                  'material/responsive'
              ]
            ]
        ];
        return $render_array;
    }
}