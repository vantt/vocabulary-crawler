<?php

namespace Vantt\Memrise\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Vantt\Memrise\GuzzleHttpRequest;
use Vantt\Memrise\MoverCourse;
use Vantt\Memrise\Page\LoginPage;
use Vantt\Memrise\Page\UploadPage;
use Vantt\Memrise\Page\WordSearchPage;

class UploadFiles extends Command
{
    protected function configure()
    {
        $this
            ->setName('memrise:upload')
            ->setDescription('upload pictures to memrise database')
            ->addArgument(
                'type',
                InputArgument::REQUIRED,
                'Upload Sounds or Pictures? [picture|sound]'
            )
            ->addArgument(
                'folder',
                InputArgument::OPTIONAL,
                'Folder that contains images files'
            );
//            ->addOption(
//                'type',
//                't',
//                InputOption::VALUE_REQUIRED,
//                'Upload Sounds or Pictures? [picture|sound]',
//                'picture'
//            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');

        if (!in_array($type, array('picture', 'sound'))){
            throw new InvalidArgumentException($type .' is invalid. Only sound or picture are supported');
        }

        $dir = $input->getArgument('folder');

        if (!file_exists($dir)) {
            $dir = getcwd().DIRECTORY_SEPARATOR.$dir;

            if (!file_exists($dir)) {
                throw new InvalidArgumentException($dir .' is not exist.');
            }
        }

        $done_folder = $dir.DIRECTORY_SEPARATOR.'done';
        @mkdir($done_folder, 0777);

        $client = new Client(['cookies' => true, 'track_redirects' => true, 'headers' => ['User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1']]);
        $http = new GuzzleHttpRequest($client);
        $course = new MoverCourse();

        $page = new LoginPage($http);
        $page->doLogin();

        $finder = new Finder();
        $cell_id = NULL;

        if ('picture' == $type) {
            $finder->files()->name('/\.(jpg|jpeg|png|gif|bmp|tif)$/')->sortByName()->in($dir)->exclude('done');
            $cell_id = 4;
        }
        elseif ('sound' == $type) {
            $finder->files()->name('/\.(mp3)$/')->sortByName()->in($dir)->exclude('done');
            $cell_id = 3;
        }

        foreach ($finder as $file) {
            /** @var SplFileInfo  $file */
            $output->writeln($file->getRealPath());

            // extract the WORD from filename
            $word = str_replace('.'.$file->getExtension(), '', $file->getFilename());

            // find the word and extract its id
            $page = new WordSearchPage($http, $course, $word);
            $thing_id = $page->getThingId();

            if ($thing_id) {
                $csrf_token = $page->getCsrfToken();
                $referer = $page->getFullUrl();

                // upload pictures
                $page = new UploadPage($http);

                if ($page->upload($csrf_token, $thing_id, $cell_id, $file->getRealPath())) {
                    rename($file->getRealPath(),$done_folder.DIRECTORY_SEPARATOR.$file->getFilename());
                }
            }
        }
    }
}