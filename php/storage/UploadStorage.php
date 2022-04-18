<?php

class UploadStorage
{
    const MAX_FILE_SIZE = 10**6;//10 mégaoctets
    //const MAX_IMAGE_SIZE = ?
    const SUPPORTED_EXTENSIONS = array('jpg','png','pdf');

    private function extensionIsSupported($extension){
        return in_array($extension, self::SUPPORTED_EXTENSIONS);
    }

    private function fileSizeValid($size){
        return $size <= self::MAX_FILE_SIZE;
    }


    public function receiveFile($file, &$message = ''){
        $fileReceived = false;
        if($file['error'] > 0){

        }else{
            if(!self::fileSizeValid($file['size'])){
                $message = 'Erreur: taille du fichier trop lourde (max 10Mo)';
            }else{
                $fileInfo = pathinfo($file['name']);
                if(!self::extensionIsSupported($fileInfo['extension'])){
                    $message = 'Erreur: extension de fichier non supportée (jpg, png ou pdf)';
                }else{
                    if(file_exists($fileInfo['filename'])){

                    }
                }
            }

        }
        return $fileReceived;
    }

}