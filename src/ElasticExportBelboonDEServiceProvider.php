<?php

namespace ElasticExportBelboonDE;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;


/**
 * Class ElasticExportBelboonDEServiceProvider
 * @package ElasticExportBelboonDE
 */
class ElasticExportBelboonDEServiceProvider extends DataExchangeServiceProvider
{
    /**
     * Abstract function for registering the service provider.
     */
    public function register()
    {

    }

    /**
     * Adds the export format to the export container.
     * @param ExportPresetContainer $container
     */
    public function exports(ExportPresetContainer $container)
    {
        $container->add(
            'BelboonDE-Plugin',
            'ElasticExportBelboonDE\ResultField\BelboonDE',
            'ElasticExportBelboonDE\Generator\BelboonDE',
            '',
            true
        );
    }
}