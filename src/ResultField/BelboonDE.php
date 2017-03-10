<?php

namespace ElasticExportBelboonDE\ResultField;

use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Mutators\ImageMutator;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;


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

        $reference = $settings->get('referrerId') ? $settings->get('referrerId') : -1;

        $itemDescriptionFields = ['texts.urlPath', 'texts.keywords'];
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
         * @var LanguageMutator $languageMutator
         */
        $languageMutator = pluginApp(LanguageMutator::class, [[$settings->get('lang')]]);

        //Fields
        $fields = [
            [
                //item
                'item.id',
                'item.manufacturer.id',

                //variation
                'id',
                'variation.availability.id',

                //images
                'images.item.type',
                'images.item.path',
                'images.item.fileType',

                'images.variation.type',
                'images.variation.path',
                'images.variation.fileType',

                //unit
                'unit.id',
                'unit.content',

                //defaultCategories
                'defaultCategories.id',

                //barcodes
                'barcodes.code',
                'barcodes.type',
            ],

            [
                $languageMutator,
            ],
        ];

        // Get the associated images if reference is selected
        if($reference != -1)
        {
            $fields[1][] = $imageMutator;
        }

        foreach($itemDescriptionFields as $itemDescriptionField)
        {
            //texts
            $fields[0][] = $itemDescriptionField;
        }

        return $fields;
    }
}
