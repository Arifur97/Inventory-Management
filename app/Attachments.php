<?php

namespace App;
use Auth;

use App\Company;
use App\UserGeneralSetting;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    protected $table = "attachments";

    protected $fillable =[
        "documents",
        "model",
    ];

    public static function store($documents, $model = null, $folderPath = '', $filename = null) {
        $images = [];
        $docPath = 'docs';

        $userGeneralSetting = UserGeneralSetting::with('company')
            ->where('user_id', Auth::user()->id)
            ->first();

        if($userGeneralSetting) {
            $companyData = Company::find($userGeneralSetting->company_id);
            $docPath = $companyData->name ?? $docPath;
        }
        foreach ($documents as $document) {
            if($filename && $filename != '') {
                $documentName = $filename . '_' . $document->getClientOriginalName();
            } else {
                $documentName = date("Y-m-d-H-i-s") . '_' . $document->getClientOriginalName();
            }
            $document->move(public_path('document/'. $docPath . '/'. $folderPath .'/'), $documentName);

            $images[] = 'document/'. $docPath . '/' . $folderPath .'/' . $documentName;
        }
        $imagesStr = implode(",", $images);
        return self::create([
            'documents' => $imagesStr,
            'model' => $model,
        ]);
    }

    public static function docUpdate($documents = null, $model = null, $oldDocs = null, $id = null, $folderPath = '', $filename = null, $oldRemovedDocs = null) {
        $images = [];
        $docPath = 'docs';

        $userGeneralSetting = UserGeneralSetting::with('company')
            ->where('user_id', Auth::user()->id)
            ->first();

        if($userGeneralSetting) {
            $companyData = Company::find($userGeneralSetting->company_id);
            $docPath = $companyData->name ?? $docPath;
        }

        if(!$documents && !$oldDocs) {
            $attach = self::where('id', '=', $id)->first();
            if ($attach !== null) {
                $attach->update([
                    'documents' => '',
                    'model' => $model,
                ]);
                return $attach;
            } else {
                return self::create([
                    'documents' => '',
                    'model' => $model,
                ]);
            }
        }

        if($documents) {
            foreach ($documents as $document) {
                if($filename && $filename != '') {
                    $documentName = $filename . '_' . $document->getClientOriginalName();
                } else {
                    $documentName = date("Y-m-d-H-i-s") . '_' . $document->getClientOriginalName();
                }
                $document->move(public_path('document/'. $docPath . '/' . $folderPath .'/'), $documentName);

                $images[] = 'document/'. $docPath . '/' . $folderPath .'/' . $documentName;
            }
            $imagesStr = implode(",", $images);
        }

        if($oldDocs ?? false) {
            try {
                $oldDocOriginalFileNameStr = '';
                if($filename && $filename != '') {
                    $oldDocsArr = explode(',', $oldDocs);
                    foreach($oldDocsArr as $oldDocFullPath) {
                        $oldDocTempArr = explode('/', $oldDocFullPath);
                        $oldDocsFileName = end($oldDocTempArr);
                        $oldDocOriginalFileNameTempArr = explode('_', $oldDocsFileName);
                        $oldDocOriginalFileNameTempStr = 'document/'. $docPath . '/' . $folderPath .'/' . $filename . '_' . end($oldDocOriginalFileNameTempArr);
                        $oldDocOriginalFileNameStr .= ($oldDocOriginalFileNameTempStr . ',');
                        rename($oldDocFullPath, $oldDocOriginalFileNameTempStr);
                    }
                }

                if($oldDocOriginalFileNameStr != '') {
                    $imagesStr = $oldDocOriginalFileNameStr . ($imagesStr ?? '');
                } else {
                    $imagesStr = $oldDocs . ',' . ($imagesStr ?? '');
                }
            } catch(\Exception $e) {}
            $imagesStr = rtrim($imagesStr, ",");
        }

        if($oldRemovedDocs ?? false) {
            try {
                foreach(explode(',', $oldRemovedDocs) as $item) {
                    unlink($item);
                }
            } catch(\Exception $e) {}
        }

        if($id != null) {
            $docs = self::where('id', '=', $id)->first();

            if ($docs !== null) {
                $docs->update([
                    'documents' => $imagesStr,
                    'model' => $model,
                ]);
                return $docs;
            } else {
                return self::create([
                    'documents' => $imagesStr,
                    'model' => $model,
                ]);
            }
        } else {
            return self::create([
                'documents' => $imagesStr,
                'model' => $model,
            ]);
        }
    }

}
