<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostMeta;
use App\Translation;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class PostsController extends Controller
{

    protected $postType;
    private $typeCategories = [
        'recipe' => 'recipe_cat',
        'advice' => 'advice_cat',
        'company' => 'company_cat',
        'exercise' => 'exercise_cat',
    ];

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->postType = Route::current()->getParameter('postType');
    }


    public function index(Request $request)
    {
        $status = $request->get('status') ?? 'publish';
        if (!in_array($status, ['publish', 'pending'])) {
            $status = 'publish';
        }
        $pendingCount = Post::where('status', 'pending')->count();
        $query = Post::where('type', str_singular($this->postType))->latest()->where('status', $status);
        //$query->with('mainAttachment.medium', 'categories');
        $posts = $query->paginate(20);
        return view('admin.posts.index', [
            'postType' => $this->postType,
            'posts' => $posts,
            'pendingCount' => $pendingCount,
            'status' => $status,
        ]);
    }


    public function create()
    {
        if (Auth::user()->cant('create', Post::class)) {
            return view('admin.errors.401');
        }

        $category = $this->typeCategories[str_singular($this->postType)];
        $categories = Category::where('type', $category)->orderBy('slug', 'asc')->get();
        return view('admin.posts.create', [
            'categories' => $categories,
            'postType' => $this->postType,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {

        $availableMetas = ['instagram_id', 'country', 'phone_number', 'address'];

        $this->validate($request, [
            'title' => 'required',
            'attachment' => 'required|exists:attachments,id',
            'access' => 'in:free,premium',
            'format' => 'in:standard,video',
        ]);
        $data = $this->prepareForDatabase($request);
        DB::transaction(function () use ($data, $availableMetas, $request) {
            $post = Post::create($data);
            Auth::user()->did('Created ' . str_singular($this->postType) . ' with id: ' . $post->id);
            if (!empty($data['category'])) {
                $post->categories()->attach($data['category']);
            }
            if (!empty($data['attachment'])) {
                $post->attachments()->attach($data['attachment'], ['type' => 'main']);
            }
            foreach ($availableMetas as $m) {
                if (isset($data[$m])) {
                    $post->addOrUpdateMeta($m, $data[$m]);
                }
            }
            $post->addOrUpdateTranslation('post_title', $request->get('arabic_title'));
            if ($this->postType != 'companies') {
                $post->addOrUpdateTranslation('post_body', $request->get('arabic_body'));
                $post->addOrUpdateTranslation('post_excerpt', $request->get('arabic_excerpt'));
            }
        });

        return redirect()->route('posts', ['postType' => $this->postType]);

    }

    private function prepareForDatabase($request)
    {
        $author = Auth::user();

        $data = $request->all();

        $data['type'] = str_singular($this->postType);
        $data['author'] = $author->id;
        if ($author->role == 'admin') {
            $data['status'] = 'publish';
        } else {
            $data['status'] = 'pending';
        }

        return $data;
    }

    public function edit($pt, Post $post)
    {
        $category = $this->typeCategories[str_singular($this->postType)];
        $categories = Category::where('type', $category)->orderBy('slug', 'asc')->get();
        $metas = $post->metas->keyBy('meta_key');
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'postType' => $this->postType,
            'isEdit' => true,
            'metas' => $metas,
        ]);
    }

    public function update($post_type, Post $post, Request $request)
    {

        $availableMetas = ['instagram_id', 'country', 'phone_number', 'address'];

        $this->validate($request, [
            'title' => 'required',
            'attachment' => 'required|exists:attachments,id',
            'access' => 'in:free,premium',
            'format' => 'in:standard,video',
        ]);

        $data = $this->prepareForDatabase($request);
        DB::transaction(function () use ($data, $post, $availableMetas, $request) {
            $post->update($data);
            Auth::user()->did('Updated ' . str_singular($this->postType) . ' with id: ' . $post->id);
            if (!empty($data['category'])) {
                $post->categories()->sync($data['category']);
            }
            if (!empty($data['attachment'])) {
                $post->mainAttachment()->sync([$data['attachment'] => ['type' => 'main']]);
            }
            foreach ($availableMetas as $m) {
                if (isset($data[$m])) {
                    $post->addOrUpdateMeta($m, $data[$m]);
                }
            }
            $post->addOrUpdateTranslation('post_title', $request->get('arabic_title'));
            if ($post->type != 'company') {
                $post->addOrUpdateTranslation('post_body', $request->get('arabic_body'));
                $post->addOrUpdateTranslation('post_excerpt', $request->get('arabic_excerpt'));
            }
        });
        return redirect()->route('editPost', ['postType' => $this->postType, 'post' => $post->id])->with('success', 'Post Updated Successfully');
    }

    public function delete($pt, Post $post)
    {
        $post->forceDelete();
        Auth::user()->did('Deleted ' . str_singular($this->postType) . ' with id: ' . $post->id);
        return redirect()->route('posts', ['postType' => $pt]);
    }

//    public function translationForm($post_type, Post $post)
//    {
//        $keys = ['post_title', 'post_body', 'post_excerpt'];
//        $translations = $post->translations;
//        $translationValues = [];
//        if (!empty($translations)) {
//            foreach ($keys as $key) {
//                $translationValues[$key] = $translations->where('translation_key', $key)->first();
//            }
//        }
//        return view('admin.posts.translation', [
//            'postType' => $this->postType,
//            'translationValues' => $translationValues,
//            'post' => $post
//        ]);
//    }

//    public function storeTranslation($post_type, Post $post, Request $request)
//    {
//        $keys = ['post_title', 'post_body', 'post_excerpt'];
//
//        $this->validate($request, [
//            'post_title' => 'required'
//        ]);
//
//        $translations = $post->translations;
//        $translationValues = [];
//        if (!empty($translations)) {
//            foreach ($keys as $key) {
//                $translationValues[$key] = $translations->where('translation_key', $key)->first();
//            }
//        }
//
//        foreach ($keys as $key) {
//            if ($request->has($key) && !empty($request->input($key))) {
//                $data = [
//                    'translation_key' => $key,
//                    'translation_value' => $request->input($key),
//                    'translation_lang' => 'ar',
//                ];
//                if (empty($translationValues[$key])) {
//                    $translation = new Translation($data);
//                    $post->translations()->save($translation);
//                } else {
//                    $translationValues[$key]->update($data);
//                }
//
//            }
//        }
//        return redirect()->route('editPost', ['postType' => $this->postType, 'post' => $post->id]);
//    }

    public function performBatchAction(Request $request)
    {
        $this->validate($request, [
            'action' => 'required',
            'batch_ids' => 'required|array',
        ]);

        $action = $request->get('action');
        $ids = $request->get('batch_ids');

        if ($action == 'delete') {
            foreach ($ids as $id) {
                Post::find($id)->forceDelete();
            }
        } elseif ($action == 'publish') {
            foreach ($ids as $id) {
                Post::find($id)->update(['status' => 'publish']);
            }
        } elseif ($action == 'pending') {
            foreach ($ids as $id) {
                Post::find($id)->update(['status' => 'pending']);
            }
        }

        return back();
    }
}
