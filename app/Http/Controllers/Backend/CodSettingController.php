<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CodSetting;
use Illuminate\Http\Request;

class CodSettingController extends Controller
{
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'integer'],

        ]);
        $id = 1;
        CodSetting::updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->status,
            ]
        );
        flash()->success('Updated successfully.');
        return redirect()->back();
    }
}
