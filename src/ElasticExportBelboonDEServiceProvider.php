<?php

namespace ElasticExportBelboonDE;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\ServiceProvider;

/**
 * Class ElasticExportBelboonDEServiceProvider
 * @package ElasticExportBelboonDE
 */
class ElasticExportBelboonDEServiceProvider extends ServiceProvider
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
    public function boot(ExportPresetContainer $container)
    {
        $container->add(
            'BelboonDE-Plugin',
            'ElasticExportBelboonDE\ResultField\BelboonDE',
            'ElasticExportBelboonDE\Generator\BelboonDE',
            '',
            true,
			true
        );
    }
}