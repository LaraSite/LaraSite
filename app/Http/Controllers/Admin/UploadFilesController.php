<?php

namespace App\Http\Controllers\Admin;

use App\Entities\UploadFile;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadFilesController extends Controller
{
    protected $uploadFile;

    public function __construct(UploadFile $uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $files = $this->uploadFile->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.upload_files.index', compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('submitted_file')) {
            return response('File has not been uploaded.', 400);
        }

        $file = $request->file('submitted_file');
        if (!$file->isValid()) {
            return response('File has not been uploaded.', 400);
        }

        $validator = \Validator::make($request->all(), [
            'submitted_file' => 'required|mimes:pdf,gif,jpeg,png|max:1024'
        ]);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        \DB::beginTransaction();
        try {
            $upload_file = $this->uploadFile->create([
                'extension' => $file->guessExtension(),
                'size' => $file->getSize()
            ]);

            $upload_file->move($file);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return response($e->getMessage(), 500);
        }

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $cnt = 0;
        $delete_items = $request->input('delete_items', []);

        $files = $this->uploadFile->whereIn('id', $delete_items)->get();

        \DB::beginTransaction();
        try {
            foreach ($files as $file) {
                $file->unlink();
                $file->delete();
                $cnt++;
            }
            \DB::commit();
            \Flash::success(trans('message.file_deleted', ['count' => $cnt]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Flash::error($e->getMessage());
        }


        return redirect(route('admin.upload_files.index'));
    }
}
