<?php
/**
 * This file is part of the symfony-test project.
 * @project symfony-test
 * @file FileUploader.php
 * @license private
 * @author Ivan A-R <aia@bileter.ru> (ivan)
 * @date 09.07.18 16:03
 */


// From https://symfony.com/doc/current/controller/upload_file

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        // TODO Генерировать имена файлов надо бы умнее, что бы имя не пересекалось с уже существующими.
        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return sha1(uniqid());
    }
}