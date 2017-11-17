<?php

namespace App\Http\Controllers;

use App\Attachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
//use League\Flysystem\File;
use Validator;
use File;


class AttachmentsController extends Controller
{

    private $sizes = [
        'medium' => ['normal', 768],
        'small' => ['normal', 300],
        'sq-small' => ['square', 300],
    ];

    protected $mediaType;

    /**
     * AttachmentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->mediaType = Route::current()->getParameter('mediaType');
    }

    public function index(Request $request)
    {
       // dd($request->all());
        $type = ($request->get('type') !== null) ? $request->get('type') : 'video'; //$request->get('type') ?? 'video';
        if (!in_array($type, ['video', 'thumbnail', 'external_youtube'])) {
            $type = 'video';
        }
        $medium = Attachment::whereNull('parent')->where('type', $type)->orderBy('created_at', 'desc')->with('squareSmall')->paginate(30);
        return view('admin.media.index', compact('medium', 'type'));
    }

    public function create()
    {
        return view('admin.media.upload');
    }

    public function uploadVideo(Request $request)
    {   
       // dd($request->all());
        // $this->validate($request, [
        //     'video' => 'required|file',
        //     'poster' => 'required|image',
        // ]);

        $video = $request->file('video');
        $videoName = $this->generateFileName($video);
        $videoFilename = $videoName['name'] . '.' . $videoName['ext'];

        $pathBase = 'videos/';
        $videoPath = $pathBase . $videoFilename;

        $videoFullPath = public_path('/uploads/' . $pathBase);
        $videoAttachment = Attachment::create(['path' => $videoPath, 'type' => 'video']);


        $video->move($videoFullPath, $videoFilename);

        $poster = $request->file('poster');
        $this->createThumbnail($poster, $videoAttachment->id, 'poster');

        return response()->json(['success' => 'Video Uploaded']);
    }

    private function generateFileName(UploadedFile $file)
    {
        $time = Carbon::now()->timestamp;
        $name = $file->getClientOriginalName();
        $fileinfo['name'] = $time . '__' . pathinfo($name, PATHINFO_FILENAME);
        $fileinfo['ext'] = $file->guessClientExtension();

        return $fileinfo;
    }

    private function createThumbnail($file, $parent = null, $type = 'thumbnail')
    {
        $img = Image::make($file->getRealPath());
        $dimensions = [$img->width(), $img->height()];
        $dim_str = implode('x', $dimensions);
        $fileinfo = $this->generateFileName($file);
        $path = $fileinfo['name'] . '.' . $fileinfo['ext'];
        $store_path = public_path('/uploads/' . $path);
        $img->save($store_path);
        $data['type'] = 'thumbnail';
        $data['path'] = $path;
        $data['size'] = $dim_str;
        $data['parent'] = $parent;
        $data['size_name'] = 'full';

        $attachment = Attachment::create($data);

        $sizesParent = ($type == 'thumbnail') ? $attachment->id : $parent;

        foreach ($this->sizes as $size => $dim) {
            $sized = $img;
            $path = $fileinfo['name'] . '__' . $size . '.' . $fileinfo['ext'];
            $store_path = public_path('/uploads/' . $path);
            if ($dim[0] == 'normal') {
                $ratio = $dimensions[0] / $dim[1];
                $sized_dim = [$dim[1], round($dimensions[1] / $ratio)];
                $sized->resize($dim[1], null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($store_path);
            } elseif ($dim[0] == 'square') {
                $sized_dim = [$dim[1], $dim[1]];
                $sized->fit($dim[1])->save($store_path);
            }


            $data['type'] = $attachment->type;
            $data['path'] = $path;
            $data['parent'] = $sizesParent;
            $data['size'] = implode('x', $sized_dim);
            $data['size_name'] = $size;

            Attachment::create($data);
        }
    }

    public function uploadThumbnail(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
        ]);

        $imageInput = $request->file('image');
        if (!is_array($imageInput)) {
            $imageInput = [$imageInput];
        }
        foreach ($imageInput as $imageFile) {
            $this->createThumbnail($imageFile);
        }

        return response()->json(['success' => 'Thumbnails Uploaded']);
    }

    public function uploadExternalLink(Request $request)
    {
        $this->validate($request, [
            'link' => 'required',
            'poster' => 'required|image',
        ]);

        $link = $request->get('link');
        $videoAttachment = Attachment::create(['path' => $link, 'type' => 'external_youtube']);

        $poster = $request->file('poster');
        $this->createThumbnail($poster, $videoAttachment->id, 'poster');

        return response()->json(['success' => 'Youtube Link added']);
    }

    public function show($filename)
    {

    }

    public function attachmentList($mediaType)
    {
        if ($mediaType == 'video') {
            $mediaTypes = ['video', 'external_youtube'];
        } else {
            $mediaTypes = ['thumbnail'];
        }
        $media = Attachment::whereIn('type', $mediaTypes)
            ->whereNull('parent')
            ->orderBy('created_at', 'desc')
            ->with('squareSmall')
            ->paginate(100);
        return response()->json($media);
    }

    public function delete($media, Request $request)
    {
        $media = Attachment::where('id', $media)->with('sizes')->first();
        // dd($media);
        $path = public_path('/uploads/' . $media->path);
       
        if (File::exists($path)) {
            File::delete($path);
        }

        $media->sizes->each(function ($size) {
            $path = public_path('/uploads/' . $size->path);
            if (File::exists($path)) {
                File::delete($path);
            }
        });

        $media->delete();

        return redirect()->route('media.all')->with('success', 'Files deleted successfully');
    }
}
