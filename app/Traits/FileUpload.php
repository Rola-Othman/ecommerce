<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use File;

// انشاء كلاس تريت لرفع الملفاتلغرض استعماله اكثر من مرة
trait FileUpload{
    /**
     * رفع الملفات.
     *
     * @param UploadedFile $file الملف الذي تم رفعه.
     * @param string $directory المجلد الي راح اخزن فيه مسار الملف.
     * @return string راح ترجع لي.
     */
    public function uploadFile(UploadedFile $file, string $directory='uploads') : string {
      try{
          $fileName = 'ecommerce_'.uniqid().'.'.$file->getClientOriginalExtension(); // انشاء اسم للملف
        //Move file to storage
        $file->storeAs($directory, $fileName, 'public'); // نقل الملف الى المجلد الي انشأناه

        return '/'.$directory.'/'.$fileName; // ارجاع مسار الملف
      }catch (\Exception $e){
        throw $e;
      }
       
    }

    /**
     * حذف الملفات.
     *
     * @param string $path مسار الملف الي ابغى احذفه.
     * @return Boolean راح ترجع لي.
     */
    public function deleteFile(?string $path):bool{
       if(File::exists(public_path($path))){
        File::delete(public_path($path)); // حذف الملف من المجلد
        return true;
       }
       return false;
    }
}