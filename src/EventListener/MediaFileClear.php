<?php

namespace App\EventListener;

use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class MediaFileClear
{
    private $entityManager;
    private $projectDir;

    public function __construct(
        string $projectDir,
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->projectDir = $projectDir;
    }

    public function postUpdate(Media $media): void
    {
        $this->delete($media);
    }
    public function postRemove(Media $media): void
    {
        $this->delete($media);
    }

    public function delete(Media $media)
    {
        $filename = $media->getUrl();
        if ($this->isUsed($filename))
            return;

        $url = $this->projectDir . "\\public\\uploads\\" . $filename;
        dump($url);
        $fs = new Filesystem();
        if (!$fs->exists($url))
            throw new \Exception("The file you're trying to delete doesn't exist.");


        $fs->remove($url);
    }

    public function isUsed($filename)
    {
        $isUsed = $this->entityManager->getRepository(Media::class)->findBy(['url' => $filename]);
        return !empty($isUsed);
    }
}
