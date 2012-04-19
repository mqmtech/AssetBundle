<?php

namespace MQM\AssetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use MQM\AssetBundle\Model\AssetManagerInterface;

class InstallAssetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mqm_asset:install:asset:filesystem')
            ->setDescription('Copy asset data from asset table to filesystem')
            ->addArgument('assetsPath', InputArgument::REQUIRED, 'Specify the path (under web) to store the assets. ex: mqm_asset:assets:install:filesystem bundles/acmebundle/images')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $assetsPath = $input->getArgument('assetsPath');
        $assetFileHelper = $this->getContainer()->get('mqm_asset.database_helper');
        $assetFileHelper->copyAssetsFromDatabaseToFilesystem($assetsPath);
    }
}