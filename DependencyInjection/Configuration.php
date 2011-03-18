<?php

namespace Stof\DoctrineExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('stof_doctrine_extensions');
        
        $builder = $rootNode->children();
        $this->addVendorConfig($builder, 'orm');
        $this->addVendorConfig($builder, 'mongodb');

        $classNode = $builder->arrayNode('class');
        $builder = $classNode->children();
        $this->addVendorClassConfig($builder, 'orm');
        $this->addVendorClassConfig($builder, 'mongodb');

        return $treeBuilder->buildTree();
    }

    private function addVendorConfig(NodeBuilder $node, $name)
    {
        $node
            ->arrayNode($name)
                ->useAttributeAsKey('id')
                ->prototype('array')
                ->performNoDeepMerging()
                ->children()
                    ->scalarNode('translatable')->defaultTrue()->end()
                    ->scalarNode('timestampable')->defaultTrue()->end()
                    ->scalarNode('sluggable')->defaultTrue()->end()
                    ->scalarNode('tree')->defaultTrue()->end()
                    ->scalarNode('loggable')->defaultTrue()->end()
                ->end()
            ->end();
    }

    private function addVendorClassConfig(NodeBuilder $node, $name)
    {
        $node
            ->arrayNode($name)
                ->children()
                    ->scalarNode('translatable')->end()
                    ->scalarNode('timestampable')->end()
                    ->scalarNode('sluggable')->end()
                    ->scalarNode('tree')->end()
                    ->scalarNode('loggable')->end()
                ->end()
            ->end();
    }
}
