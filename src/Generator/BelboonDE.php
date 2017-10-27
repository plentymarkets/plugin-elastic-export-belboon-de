<?php

namespace ElasticExportBelboonDE\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExport\Helper\ElasticExportPriceHelper;
use ElasticExport\Helper\ElasticExportStockHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Plugin\Log\Loggable;

/**
 * Class BelboonDE
 * @package ElasticExportBelboonDE\Generator
 */
class BelboonDE extends CSVPluginGenerator
{
	use Loggable;

    const DELIMITER = ';';

    const IMAGE_SIZE_WIDTH  = 'width';
    const IMAGE_SIZE_HEIGHT = 'height';

    /**
     * @var ElasticExportCoreHelper
     */
    private $elasticExportHelper;

	/**
	 * @var ElasticExportPriceHelper
	 */
    private $elasticExportPriceHelper;

	/**
	 * @var ElasticExportStockHelper
	 */
    private $elasticExportStockHelper;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

	/**
	 * @var array
	 */
	private $shippingCostCache = [];

    /**
     * BelboonDE constructor.
     *
     * @param ArrayHelper $arrayHelper
     */
    public function __construct( ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * Generates and populates the data into the CSV file.
     *
     * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
     * @param array                                          $formatSettings
     * @param array                                          $filter
     */
    protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
    {
    	// Initialize helper classes
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);

        $this->elasticExportPriceHelper = pluginApp(ElasticExportPriceHelper::class);

        $this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);

		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

		$this->setDelimiter(self::DELIMITER);

        $this->addCSVContent($this->head());

        if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
        {
        	$elasticSearch->setNumberOfDocumentsPerShard(250);
        	
            // Initiate the counter for the variations limit
            $limitReached = false;
            $limit = 0;

            do
            {
                // Stop writing if limit is reached
                if($limitReached === true)
                {
                    break;
                }

                // Get the data from Elastic Search
                $resultList = $elasticSearch->execute();

                if(count($resultList['error']) > 0)
                {
                    $this->getLogger(__METHOD__)->error('ElasticExportBelboonDE::logs.occurredElasticSearchErrors', [
                        'Error message' => $resultList['error'],
                    ]);

                    break;
                }

                if(is_array($resultList['documents']) && count($resultList['documents']) > 0)
                {
                    $previousItemId = null;

                    foreach($resultList['documents'] as $variation)
                    {
                        // Stop and set the flag if limit is reached
                        if($limit == $filter['limit'])
                        {
                            $limitReached = true;
                            break;
                        }

                        // If filtered by stock is set and stock is negative, then skip the variation
                        if ($this->elasticExportStockHelper->isFilteredByStock($variation, $filter) === true)
                        {
                            continue;
                        }

                        try
                        {
                            // Set the caches if we have the first variation or when we have the first variation of an item
                            if($previousItemId === null || $previousItemId != $variation['data']['item']['id'])
                            {
                                $previousItemId = $variation['data']['item']['id'];
                                unset($this->shippingCostCache);

                                // Build the caches arrays
                                $this->buildCaches($variation, $settings);
                            }

                            // Build the new row for printing in the CSV file
                            $this->buildRow($variation, $settings);
                        }
                        catch(\Throwable $throwable)
                        {
                            $this->getLogger(__METHOD__)->error('ElasticExportBelboonDE::logs.fillRowError', [
                                'Error message ' => $throwable->getMessage(),
                                'Error line'     => $throwable->getLine(),
                                'VariationId'    => $variation['id']
                            ]);
                        }

                        // New line was added
                        $limit++;
                    }
                }

            } while ($elasticSearch->hasNext());
        }
    }

    /**
     * Creates the header of the CSV file.
     *
     * @return array
     */
    private function head():array
    {
        return array(
            'Merchant_ProductNumber',
            'EAN_Code',
            'Product_Title',
            'Brand',
            'Price',
            'Price_old',
            'Currency',
            'Valid_From',
            'Valid_To',
            'DeepLink_URL',
            'Image_Small_URL',
            'Image_Small_WIDTH',
            'Image_Small_HEIGHT',
            'Image_Large_URL',
            'Image_Large_WIDTH',
            'Image_Large_HEIGHT',
            'Merchant_Product_Category',
            'Keywords',
            'Product_Description_Short',
            'Product_Description_Long',
            'Last_Update',
            'Shipping',
            'Availability',
            'Unit_Price',
        );
    }

	/**
     * Creates the variation row and prints it into the CSV file.
     *
	 * @param array     $variation
	 * @param KeyValue  $settings
	 */
    private function buildRow($variation, $settings)
	{
		// Get prices
		$priceList = $this->elasticExportPriceHelper->getPriceList($variation, $settings, 2, '.');

        // Only variations with the Retail Price greater than zero will be handled
        if(!is_null($priceList['price']) && (float)$priceList['price'] > 0)
        {
            $imageStartTime = microtime(true);

            // Get preview and large image information
            $imageInformation = $this->getImageInformation($variation, $settings, 'preview');

            $this->getLogger(__METHOD__)->debug('ElasticExportBelboonDE::logs.imageInformationDuration', [
                'Image information duration' => microtime(true) - $imageStartTime,
            ]);

            $data = [
                'Merchant_ProductNumber'      => $variation['id'],
                'EAN_Code'                    => $this->elasticExportHelper->getBarcodeByType($variation, $settings->get('barcode')),
                'Product_Title'               => $this->elasticExportHelper->getMutatedName($variation, $settings),
                'Brand'                       => $this->elasticExportHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
                'Price'                       => $priceList['price'],
                'Price_old'                   => $priceList['recommendedRetailPrice'],
                'Currency'                    => $priceList['currency'],
                'Valid_From'                  => $this->getDate($variation['data']['variation']['releasedAt']),
                'Valid_To'                    => $this->getDate($variation['data']['variation']['availableUntil']),
                'DeepLink_URL'                => $this->elasticExportHelper->getMutatedUrl($variation, $settings),
				'Image_Small_URL'             => $imageInformation['preview']['url'],
				'Image_Small_WIDTH'           => $imageInformation['preview']['width'],
				'Image_Small_HEIGHT'          => $imageInformation['preview']['height'],
				'Image_Large_URL'             => $imageInformation['normal']['url'],
				'Image_Large_WIDTH'           => $imageInformation['normal']['width'],
				'Image_Large_HEIGHT'          => $imageInformation['normal']['height'],
                'Merchant_Product_Category'   => $this->elasticExportHelper->getCategory((int)$variation['data']['defaultCategories'][0]['id'], $settings->get('lang'), $settings->get('plentyId')),
                'Keywords'                    => $variation['data']['texts']['keywords'],
                'Product_Description_Short'   => $this->elasticExportHelper->getMutatedPreviewText($variation, $settings),
                'Product_Description_Long'    => $this->elasticExportHelper->getMutatedDescription($variation, $settings),
                'Last_Update'                 => $this->getDate($variation['data']['variation']['updatedAt']),
                'Shipping'                    => $this->getShipping($variation),
                'Availability'                => $this->elasticExportHelper->getAvailability($variation, $settings, true),
                'Unit_Price'                  => $this->elasticExportPriceHelper->getBasePrice($variation, $priceList['price'], $settings->get('lang')),
            ];

            $this->addCSVContent(array_values($data));
        }
	}

    /**
     * Get date in correct format.
     *
     * @param  string $date
     * @return string
     */
	private function getDate($date):string
    {
        if(strlen($date) && substr($date, 0, -6) != '0000-00-00T00:00:00')
        {
            $date = str_replace('T', ' ', $date);
            $date = substr($date, 0, -6);

            return $date;
        }

        return '';
    }

    /**
     * Get image information.
     *
     * @param  array    $variation
     * @param  KeyValue $settings
     * @param  string   $imageType
     * @return array
     */
	private function getImageInformation($variation, KeyValue $settings, string $imageType):array
	{
		$image = $this->elasticExportHelper->getImageListInOrder($variation, $settings, 1, ElasticExportCoreHelper::VARIATION_IMAGES, $imageType, true);

		$imageInformation = [
			'preview' => [
				'url' => '',
				'width' => '',
				'height' => '',
			],
			'normal' => [
				'url' => '',
				'width' => '',
				'height' => '',
			]
		];

		foreach($image as $imageData)
		{
			if(strlen($imageData['urlPreview']) > 0)
			{
				$imageInformation['preview'] = [
					'url' => $imageData['urlPreview'],
					'width' => isset($imageData['width']) ? $imageData['width'] : 0,
					'height' => isset($imageData['height']) ? $imageData['width'] : 0,
				];
			}

			if(strlen($imageData['url']) > 0)
			{
				$imageInformation['normal'] = [
					'url' => $imageData['url'],
					'width' => isset($imageData['width']) ? $imageData['width'] : 0,
					'height' => isset($imageData['height']) ? $imageData['width'] : 0,
				];
			}
		}

		return $imageInformation;
	}

    /**
     * Get the shipping cost.
     *
     * @param  array $variation
     * @return string
     */
    private function getShipping($variation):string
    {
        $shippingCost = null;
        if(isset($this->shippingCostCache) && array_key_exists($variation['data']['item']['id'], $this->shippingCostCache))
        {
            $shippingCost = $this->shippingCostCache[$variation['data']['item']['id']];
        }

        if(!is_null($shippingCost) && $shippingCost > 0)
        {
            return number_format((float)$shippingCost, 2, '.', '');
        }

        return '';
    }

    /**
     * Build the cache arrays for the item variation.
     *
     * @param array    $variation
     * @param KeyValue $settings
     */
    private function buildCaches($variation, $settings)
    {
        if(!is_null($variation) && !is_null($variation['data']['item']['id']))
        {
            $shippingCost = $this->elasticExportHelper->getShippingCost($variation['data']['item']['id'], $settings);
            $this->shippingCostCache[$variation['data']['item']['id']] = (float)$shippingCost;
        }
    }
}
