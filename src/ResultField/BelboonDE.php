<?php

namespace ElasticExportBelboonDE\ResultField;

use ElasticExport\DataProvider\ResultFieldDataProvider;
use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Mutators\BarcodeMutator;
use Plenty\Modules\Item\Search\Mutators\DefaultCategoryMutator;
use Plenty\Modules\Item\Search\Mutators\ImageMutator;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;
use Plenty\Modules\Item\Search\Mutators\KeyMutator;
use Plenty\Plugin\Log\Loggable;

/**
 * Class BelboonDE
 * @package ElasticExportBelboonDE\ResultField
 */
class BelboonDE extends ResultFields
{
	use Loggable;
	
    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

    /**
     * BelboonDE constructor.
     *
     * @param ArrayHelper $arrayHelper
     */
    public function __construct(ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * Creates the fields set to be retrieved from ElasticSearch.
     *
     * @param array $formatSettings
     * @return array
     */
    public function generateResultFields(array $formatSettings = []):array
    {
        $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

        $reference = $settings->get('referrerId');

        //Mutator
        /**
         * @var ImageMutator $imageMutator
         */
        $imageMutator = pluginApp(ImageMutator::class);
        if($imageMutator instanceof ImageMutator)
        {
            $imageMutator->addMarket($reference);
        }

        /**
         * @var KeyMutator
         */
        $keyMutator = pluginApp(KeyMutator::class);
        if($keyMutator instanceof KeyMutator)
        {
            $keyMutator->setKeyList($this->getKeyList());
            $keyMutator->setNestedKeyList($this->getNestedKeyList());
        }

        /**
         * @var LanguageMutator $languageMutator
         */
        $languageMutator = pluginApp(LanguageMutator::class, [[$settings->get('lang')]]);

        /**
         * @var DefaultCategoryMutator $defaultCategoryMutator
         */
        $defaultCategoryMutator = pluginApp(DefaultCategoryMutator::class);
        if($defaultCategoryMutator instanceof DefaultCategoryMutator)
        {
            $defaultCategoryMutator->setPlentyId($settings->get('plentyId'));
        }

        /**
         * @var BarcodeMutator $barcodeMutator
         */
        $barcodeMutator = pluginApp(BarcodeMutator::class);
        if($barcodeMutator instanceof BarcodeMutator)
        {
            $barcodeMutator->addMarket($reference);
        }

		$resultFieldHelper = pluginApp(ResultFieldDataProvider::class);
		if($resultFieldHelper instanceof ResultFieldDataProvider)
		{
			$resultFields = $resultFieldHelper->getResultFields($settings);
		}

		if(isset($resultFields) && is_array($resultFields) && count($resultFields))
		{
			$fields[0] = $resultFields;
			$fields[1] = [
				$languageMutator,
				$defaultCategoryMutator,
				$barcodeMutator,
				$keyMutator
			];

			if($reference != -1)
			{
				$fields[1][] = $imageMutator;
			}
		}
		else
		{
			$this->getLogger(__METHOD__)->critical('ElasticExportBelboonDE::log.resultFieldError');
			exit();
		}
		
        // Get the associated images if reference is selected
        if($reference != -1)
        {
            $fields[1][] = $imageMutator;
        }

        return $fields;
    }

    /**
     * Returns the list of keys.
     *
     * @return array
     */
    private function getKeyList()
	{
		return [
			// Item
			'item.id',
			'item.manufacturer.id',

			// Variation
            'variation.availability.id',
            'variation.stockLimitation',
            'variation.releasedAt',
            'variation.availableUntil',
            'variation.updatedAt',

			// Unit
			'unit.content',
			'unit.id',
		];
	}

    /**
     * Returns the list of nested keys.
     *
     * @return mixed
     */
	private function getNestedKeyList()
	{
		return [
			'keys' => [
				// Barcodes
				'barcodes',

				// Default categories
				'defaultCategories',

				// Images
				'images.all',
				'images.item',
				'images.variation',

                // Texts
                'texts',
			],

			'nestedKeys' => [
				// Barcodes
				'barcodes' => [
					'code',
					'type',
				],

				// Default categories
				'defaultCategories' => [
					'id',
				],

				// Images
				'images.all' => [
					'urlMiddle',
					'urlPreview',
					'urlSecondPreview',
					'url',
					'path',
					'position',
				],
				'images.item' => [
					'urlMiddle',
					'urlPreview',
					'urlSecondPreview',
					'url',
					'path',
					'position',
				],
				'images.variation' => [
					'urlMiddle',
					'urlPreview',
					'urlSecondPreview',
					'url',
					'path',
					'position',
				],

				// Texts
				'texts' => [
                    'urlPath',
                    'lang',
                    'name1',
                    'name2',
                    'name3',
                    'shortDescription',
                    'description',
                    'technicalData',
                    'keywords',
				],
			],
		];
	}
}
