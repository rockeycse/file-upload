<?php
   
namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
  
class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        return view('fileUpload');
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request)
    {
        // dd($request->file('file')->getMimeType());
        // dd($request->file('file')->getMimeType(),$request->file('file')->getClientOriginalExtension() );

        $request->validate([
            'file' => 'required|mimes:csv,csv,txt|max:72864',
        ]);
  
        $fileName = time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('uploads'), $fileName);
   
        // $imageName = $this->processImage($request->image);  
        // $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        // $input = $request->all();
        // $input['image'] = $imageName;
        // $input['user_id'] = auth()->user()->id;
        
   
            $data = FileUpload::query()->create([
                'file_name' => $fileName = time().'_'.$request->file('file')->getClientOriginalName(),
                'file_path' =>  $request->file('file')->getRealPath()
            ]);
            $data->save();

        return back()
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);
   
    }
}