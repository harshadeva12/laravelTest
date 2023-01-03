<?php

namespace App\Http\Controllers;

use Google\Analytics\Data\V1alpha\DateRange;
use Google\Analytics\Data\V1alpha\Dimension;
use Google\Analytics\Data\V1alpha\Metric;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Cloud\Dialogflow\V2\EntityTypesClient;

class AnaliticController extends Controller
{

    // public function test(){
    //     $entityTypesClient = new EntityTypesClient();
    //     $projectId = '250004716';
    //     $entityTypeId = '343340271';
    //     $formattedEntityTypeName = $entityTypesClient->entityTypeName($projectId, $entityTypeId);

    //     $entityType = $entityTypesClient->getEntityType($formattedEntityTypeName);
    //     foreach ($entityType->getEntities() as $entity) {
    //         print(PHP_EOL);
    //         printf('Entity value: %s' . PHP_EOL, $entity->getValue());
    //         print('Synonyms: ');
    //         foreach ($entity->getSynonyms() as $synonym) {
    //             print($synonym . "\t");
    //         }
    //         print(PHP_EOL);
    //     }
    // }

    public function test()
    {
        /**
         * TODO(developer): Replace this variable with your Google Analytics 4
         *   property ID before running the sample.
         */
        $property_id = '343340271';

        // Using a default constructor instructs the client to use the credentials
        // specified in GOOGLE_APPLICATION_CREDENTIALS environment variable.
        $client = new BetaAnalyticsDataClient();


        // Make an API call.
        $response = $client->runReport([
            'property' => 'properties/' . $property_id,
            'dateRanges' => [
                new DateRange([
                    'start_date' => '2020-03-31',
                    'end_date' => 'today',
                ]),
            ],
            'dimensions' => [
                new Dimension(
                    [
                        'name' => 'city',
                    ]
                ),
            ],
            'metrics' => [
                new Metric(
                    [
                        'name' => 'activeUsers',
                    ]
                )
            ]
        ]);

        // Print results of an API call.
        print 'Report result: ' . PHP_EOL;

        foreach ($response->getRows() as $row) {
            print $row->getDimensionValues()[0]->getValue()
                . ' ' . $row->getMetricValues()[0]->getValue() . PHP_EOL;
        }
    }
}
