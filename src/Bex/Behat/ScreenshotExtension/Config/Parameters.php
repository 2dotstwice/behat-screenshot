<?php

namespace Bex\Behat\ScreenshotExtension\Config;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

/**
 * This class represents the configurable parameters of the Behat extension
 *
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class Parameters
{
    /** @var string $activeImageDriver */
    private $activeImageDriver;

    /** @var array */
    private $imageDriver;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        var_dump($config); exit;
        $this->activeImageDriver = $config['active_image_driver'];
        $this->imageDriver['local'] = $config['image_driver']['local'];
    }

    /**
     * Defines the list of parameters in behat.yml parameters allowed by this extension
     *
     * @param ArrayNodeDefinition $builder
     *
     * @return NodeDefinition
     */
    public static function configure(ArrayNodeDefinition $builder)
    {
        $tempDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'behat-screenshot';

        $builder->children()
            ->scalarNode('active_image_driver')->defaultValue('local')->end()
            ->arrayNode('image_driver')
                ->prototype('array')
                    ->children()
                        ->arrayNode('local')
                            ->children()
                                ->scalarNode('screenshot_directory')->defaultValue($tempDirectory)->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('upload_pie')
                            ->children()
                                ->scalarNode('expire')->defaultValue(30)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }

    /**
     *
     * @return mixed
     */
    public function getActiveImageDriver()
    {
        return 'bex.screenshot_extension.image_driver.' . $this->activeImageDriver;
    }

    public function getScreenshotDirectory()
    {
        return $this->imageDriver['local']['screenshot_directory'];
    }
}