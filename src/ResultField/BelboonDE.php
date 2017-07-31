<?php

namespace ElasticExportBelboonDE\ResultField;

use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Mutators\BarcodeMutator;
use Plenty\Modules\Item\Search\Mutators\DefaultCategoryMutator;
use Plenty\Modules\Item\Search\Mutators\ImageMutator;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;
use Plenty\Modules\Item\Search\Mutators\KeyMutator;

/**
 * Class BelboonDE
 * @package ElasticExportBelboonDE\ResultField
 */
class BelboonDE extends ResultFields
{
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

        $itemDescriptionFields = ['texts.urlPath', 'texts.lang', 'texts.keywords'];

        $itemDescriptionFields[] = ($settings->get('nameId')) ? 'texts.name' . $settings->get('nameId') : 'texts.name1';

        if($settings->get('descriptionType') == 'itemShortDescription'
            || $settings->get('previewTextType') == 'itemShortDescription')
        {
            $itemDescriptionFields[] = 'texts.shortDescription';
        }

        if($settings->get('descriptionType') == 'itemDescription'
            || $settings->get('descriptionType') == 'itemDescriptionAndTechnicalData'
            || $settings->get('previewTextType') == 'itemDescription'
            || $settings->get('previewTextType') == 'itemDescriptionAndTechnicalData')
        {
            $itemDescriptionFields[] = 'texts.description';
        }

        if($settings->get('descriptionType') == 'technicalData'
            || $settings->get('descriptionType') == 'itemDescriptionAndTechnicalData'
            || $settings->get('previewTextType') == 'technicalData'
            || $settings->get('previewTextType') == 'itemDescriptionAndTechnicalData')
        {
            $itemDescriptionFields[] = 'texts.technicalData';
        }

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

        //Fields
        $fields = [
            [
                // Item
                'item.id',
                'item.manufacturer.id',

                // Variation
                'id',
                'variation.availability.id',
                'variation.stockLimitation',
                'variation.releasedAt',
                'variation.availableUntil',
                'variation.updatedAt',

				// Unit
				'unit.id',
				'unit.content',

                // Images
                'images.all.urlMiddle',
                'images.all.urlPreview',
                'images.all.urlSecondPreview',
                'images.all.url',
                'images.all.path',
                'images.all.position',

                'images.item.urlMiddle',
                'images.item.urlPreview',
                'images.item.urlSecondPreview',
                'images.item.url',
                'images.item.path',
                'images.item.position',

                'images.variation.urlMiddle',
                'images.variation.urlPreview',
                'images.variation.urlSecondPreview',
                'images.variation.url',
                'images.variation.path',
                'images.variation.position',

                // DefaultCategories
                'defaultCategories.id',

                // Barcodes
                'barcodes.code',
                'barcodes.type',
            ],

            [
                $languageMutator,
                $defaultCategoryMutator,
                $barcodeMutator,
                $keyMutator,
            ],
        ];

        // Get the associated images if reference is selected
        if($reference != -1)
        {
            $fields[1][] = $imageMutator;
        }

        foreach($itemDescriptionFields as $itemDescriptionField)
        {
            // Texts
            $fields[0][] = $itemDescriptionField;
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
