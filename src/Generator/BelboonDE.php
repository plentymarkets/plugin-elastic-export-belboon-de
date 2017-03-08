<?php

namespace ElasticExportBelboonDE\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\Helper\Contracts\UrlBuilderRepositoryContract;
use Plenty\Modules\Helper\Models\KeyValue;

class BelboonDE extends CSVPluginGenerator
{
    const DELIMITER = ';';

    const IMAGE_SIZE_WIDTH = 'width';
    const IMAGE_SIZE_HEIGHT = 'height';

    /**
     * @var ElasticExportCoreHelper
     */
    private $elasticExportCoreHelper;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

    /**
     * @var array $idlVariations
     */
    private $idlVariations = array();

    /**
     * BelboonDE constructor.
     * @param ArrayHelper $arrayHelper
     */
    public function __construct( ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * @param RecordList $resultData
     * @param array $formatSettings
     */
    protected function generatePluginContent( $resultData, array $formatSettings = [], array $filter = [])
    {

        $this->elasticExportCoreHelper = pluginApp(ElasticExportCoreHelper::class);

        if(is_array($resultData) && count($resultData['documents']) > 0)
        {
            $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

            $this->setDelimiter(self::DELIMITER);

            $this->addCSVContent([
                'Merchant_ProductNumber',
                'EAN_Code',
                'Product_Title',
                'Brand',
                'Price',
                'Currency',
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
                'Shipping',
                'Availability',
                'Unit_Price',
            ]);

            // Create a List of all VariationIds
            $variationIdList = array();
            foreach($resultData['documents'] as $variation)
            {
                $variationIdList[] = $variation['id'];
            }

            // Get the ElasticSearch missing fields from IDL(ItemDataLayer)
            if(is_array($variationIdList) && count($variationIdList) > 0)
            {
                /**
                 * @var \ElasticExportBelboonDE\IDL_ResultList\BelboonDE $idlResultList
                 */
                $idlResultList = pluginApp(\ElasticExportBelboonDE\IDL_ResultList\BelboonDE::class);
                $idlResultList = $idlResultList->getResultList($variationIdList, $settings, $filter);
            }

            //Creates an array with the variationId as key to surpass the sorting problem
            if(isset($idlResultList) && $idlResultList instanceof RecordList)
            {
                $this->createIdlArray($idlResultList);
            }

            foreach($resultData['documents'] as $variation)
            {
                $previewImageInformation = $this->getImageInformation($variation, $settings, 'preview');
                $largeImageInformation = $this->getImageInformation($variation, $settings, 'normal');
                $shipping = $this->elasticExportCoreHelper->getShippingCost($variation['data']['item']['id'], $settings);

                if(!is_null($shipping))
                {
                    $shipping = number_format((float)$shipping, 2, ',', '');
                }
                else
                {
                    $shipping = '';
                }

                $data = [
                    'Merchant_ProductNumber'      => $variation['data']['item']['id'],
                    'EAN_Code'                    => $variation['data']['barcodes']['code'],
                    'Product_Title'               => $this->elasticExportCoreHelper->getName($variation, $settings, 256),
                    'Brand'                       => $this->elasticExportCoreHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
                    'Price'                       => number_format((float)$this->idlVariations[$variation['id']]['variationRetailPrice.price'], 2, '.', ''),
                    'Currency'                    => $this->idlVariations[$variation['id']]['variationRetailPrice.currency'],
                    'DeepLink_URL'                => $this->elasticExportCoreHelper->getUrl($variation, $settings),
                    'Image_Small_URL'             => $previewImageInformation['url'],
                    'Image_Small_WIDTH'           => $previewImageInformation['width'],
                    'Image_Small_HEIGHT'          => $previewImageInformation['height'],
                    'Image_Large_URL'             => $largeImageInformation['url'],
                    'Image_Large_WIDTH'           => $largeImageInformation['width'],
                    'Image_Large_HEIGHT'          => $largeImageInformation['height'],
                    'Merchant_Product_Category'   => $this->elasticExportCoreHelper->getCategory((int)$variation['data']['defaultCategories'][0]['id'], $settings->get('lang'), $settings->get('plentyId')),
                    'Keywords'                    => $variation['data']['texts']['keywords'],
                    'Product_Description_Short'   => $this->elasticExportCoreHelper->getPreviewText($variation, $settings, 256),
                    'Product_Description_Long'    => $this->elasticExportCoreHelper->getDescription($variation, $settings, 256),
                    'Shipping'                    => $shipping,
                    'Availability'                => $this->elasticExportCoreHelper->getAvailability($variation, $settings, false),
                    'Unit_Price'                  => $this->elasticExportCoreHelper->getBasePrice($variation, $this->idlVariations[$variation['id']], $settings->get('lang')),
                ];

                $this->addCSVContent(array_values($data));
            }
        }
    }

    private function getImageInformation($variation, KeyValue $settings, string $imageType):array
    {
        $imageList = $this->elasticExportCoreHelper->getImageList($variation, $settings, $imageType);

        if(count($imageList) > 0)
        {
            $result = getimagesize($imageList[0]);
            $imageInformation = [
                'url' => $imageList[0],
                'width' => (int)$result[0],
                'height' => (int)$result[1],
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

    /**
     * Creates an array with the rest of data needed from the ItemDataLayer.
     * @param RecordList $idlResultList
     */
    private function createIdlArray($idlResultList)
    {
        if($idlResultList instanceof RecordList)
        {
            foreach($idlResultList as $idlVariation)
            {
                if($idlVariation instanceof Record)
                {
                    $this->idlVariations[$idlVariation->variationBase->id] = [
                        'itemBase.id' => $idlVariation->itemBase->id,
                        'variationBase.id' => $idlVariation->variationBase->id,
                        'variationStock.stockNet' => $idlVariation->variationStock->stockNet,
                        'variationRetailPrice.price' => $idlVariation->variationRetailPrice->price,
                        'variationRetailPrice.currency' => $idlVariation->variationRetailPrice->currency,
                    ];
                }
            }
        }
    }
}
