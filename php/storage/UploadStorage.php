<?php

namespace NoDebt;

class UploadStorage
{
    const UPLOADS_DIR = '/uploads';
    const MAX_FILE_SIZE = 10000000;//10 mégaoctets
    //const MAX_IMAGE_SIZE = ?
    const SUPPORTED_EXTENSIONS = array('jpg','png','gif');

    public $dirPath;

    public function __construct()
    {
        $this->dirPath = $_SERVER['DOCUMENT_ROOT'].self::UPLOADS_DIR.'/';
    }

    private function extensionIsSupported($extension){
        return in_array($extension, self::SUPPORTED_EXTENSIONS);
    }

    private function fileSizeValid($size){
        return $size <= self::MAX_FILE_SIZE;
    }


    public function receiveFile($file, $expense, &$message = ''){
        $fileReceived = false;
        if($file['error'] > 0){
            $this->handleError($file, $message);
        }else{
            if(!self::fileSizeValid($file['size'])){
                $message = 'Erreur: taille du fichier trop lourde (max 10Mo)';
            }else{
                $fileInfo = pathinfo($file['name']);
                if(!self::extensionIsSupported($fileInfo['extension'])){
                    $message = 'Erreur: extension de fichier non supportée (jpg, png ou gif)';
                }else{
                    if(file_exists($file['tmp_name'])){
                        $filename = 'expense'. $expense->did . '_'. time() . '.' .$fileInfo['extension'];
                        $filePath = $this->getAbsolutePath($filename);
                        if(move_uploaded_file($file['tmp_name'],$filePath)){
                            $message = 'Fichier bien envoyé !';
                            return $filename;
                        }
                    }else{
                        $message = 'Erreur : Fichier introuvable, veuillez réessayer.';
                    }
                }
            }

        }
        return $fileReceived;
    }

    private function handleError($file, &$message){
        switch($file['error']){
            case UPLOAD_ERR_NO_FILE:
                $message = 'Erreur: Pas de fichier sélectionné';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'Erreur lors de l\'envoie du fichier, veuillez réessayer';
                break;
            case UPLOAD_ERR_FORM_SIZE:
            case UPLOAD_ERR_INI_SIZE:
                $message = 'Erreur: Fichier trop volumineux - Maximum 10 Mégaoctets';
                break;
            default:
                $message = 'Erreur: Veuillez réessayer';
                break;
        }
    }

    private function getAbsolutePath($filename){
        return $this->dirPath.$filename;
    }

    public function getRelativePath($filename){
        return self::UPLOADS_DIR.'/'.$filename;
    }

}