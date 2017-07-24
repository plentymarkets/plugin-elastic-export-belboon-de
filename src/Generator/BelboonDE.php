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
     * @var ElasticExportCoreHelper $elasticExportCoreHelper
     */
    private $elasticExportCoreHelper;

	/**
	 * @var ElasticExportPriceHelper $elasticExportPriceHelper
	 */
    private $elasticExportPriceHelper;

	/**
	 * @var ElasticExportStockHelper $elasticExportStockHelper
	 */
    private $elasticExportStockHelper;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

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
    	//initialize helper classes
        $this->elasticExportCoreHelper = pluginApp(ElasticExportCoreHelper::class);
        $this->elasticExportPriceHelper = pluginApp(ElasticExportPriceHelper::class);
        $this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);

		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

		$this->setDelimiter(self::DELIMITER);

		$this->addCSVContent([
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
		]);

		if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
		{
			$limitReached = false;
			$lines = 0;
			do
			{
				if($limitReached === true)
				{
					break;
				}

				$resultList = $elasticSearch->execute();

				foreach($resultList['documents'] as $variation)
				{
					if($lines == $filter['limit'])
					{
						$limitReached = true;
						break;
					}

					if(is_array($resultList['documents']) && count($resultList['documents']) > 0)
					{
						if($this->elasticExportStockHelper->isFilteredByStock($variation, $filter) === true)
						{
							continue;
						}

						try
						{
							$this->buildRow($variation, $settings);
							$lines = $lines +1;
						}
						catch(\Throwable $throwable)
						{
							$this->getLogger(__METHOD__)->error('ElasticExportBelboonDE::logs.fillRowError', [
								'Error message ' => $throwable->getMessage(),
								'Error line'    => $throwable->getLine(),
								'VariationId'   => $variation['id']
							]);
						}
					}
				}
			}while ($elasticSearch->hasNext());
		}
    }

	/**
	 * @param array     $variation
	 * @param KeyValue  $settings
	 */
    private function buildRow($variation, $settings)
	{
		// Get preview and large image information
		$previewImageInformation = $this->getImageInformation($variation, $settings, 'preview');
		$largeImageInformation = $this->getImageInformation($variation, $settings, 'normal');

		//get prices
		$priceList = $this->elasticExportPriceHelper->getPriceList($variation, $settings, 2, '.');

		// Get shipping costs
		$shipping = $this->elasticExportCoreHelper->getShippingCost($variation['data']['item']['id'], $settings);
		if(!is_null($shipping))
		{
			$shipping = number_format((float)$shipping, 2, '.', '');
		}
		else
		{
			$shipping = '';
		}

		$data = [
			'Merchant_ProductNumber'      => $variation['id'],
			'EAN_Code'                    => $this->elasticExportCoreHelper->getBarcodeByType($variation, $settings->get('barcode')),
			'Product_Title'               => $this->elasticExportCoreHelper->getMutatedName($variation, $settings),
			'Brand'                       => $this->elasticExportCoreHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
			'Price'                       => $priceList['price'],
            'Price_old'                   => $priceList['recommendedRetailPrice'],
			'Currency'                    => $priceList['currency'],
            'Valid_From'                  => $this->getDate($variation['data']['variation']['releasedAt']),
            'Valid_To'                    => $this->getDate($variation['data']['variation']['availableUntil']),
			'DeepLink_URL'                => $this->elasticExportCoreHelper->getMutatedUrl($variation, $settings),
			'Image_Small_URL'             => $previewImageInformation['url'],
			'Image_Small_WIDTH'           => $previewImageInformation['width'],
			'Image_Small_HEIGHT'          => $previewImageInformation['height'],
			'Image_Large_URL'             => $largeImageInformation['url'],
			'Image_Large_WIDTH'           => $largeImageInformation['width'],
			'Image_Large_HEIGHT'          => $largeImageInformation['height'],
			'Merchant_Product_Category'   => $this->elasticExportCoreHelper->getCategory((int)$variation['data']['defaultCategories'][0]['id'], $settings->get('lang'), $settings->get('plentyId')),
			'Keywords'                    => $variation['data']['texts']['keywords'],
			'Product_Description_Short'   => $this->elasticExportCoreHelper->getMutatedPreviewText($variation, $settings),
			'Product_Description_Long'    => $this->elasticExportCoreHelper->getMutatedDescription($variation, $settings),
            'Last_Update'                 => $this->getDate($variation['data']['variation']['updatedAt']),
			'Shipping'                    => $shipping,
			'Availability'                => $this->elasticExportCoreHelper->getAvailability($variation, $settings, true),
			'Unit_Price'                  => $this->elasticExportPriceHelper->getBasePrice($variation, $priceList['price'], $settings->get('lang')),
		];

		$this->addCSVContent(array_values($data));
	}

    /**
     * get date in correct format
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
        $imageList = $this->elasticExportCoreHelper->getImageList($variation, $settings, $imageType);

        if(count($imageList) > 0)
        {
            $result = getimagesize($imageList[0]);
            $imageInformation = [
                'url' => $imageList[0],
                'width' => (int)$result[0] ? (int)$result[0] : 0,
                'height' => (int)$result[1] ? (int)$result[1] : 0,
            ];
        }
        else
        {
            $imageInformation = [
                'url' => '',
                'width' => '',
                'height' => '',
            ];
        }

        return $imageInformation;
    }
}
