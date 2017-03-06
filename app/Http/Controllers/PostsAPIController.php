<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostsAPIController extends Controller
{


    private $userType = 'free';

    /**
     * PostsAPIController constructor.
     */
    public function __construct()
    {
        try {
            if ($user = JWTAuth::parseToken()->authenticate()) {
                $this->userType = 'premium';
            }
        } catch (Exception $e) {
            // do nothing here
        }
    }

    public function index($post_type, Request $request)
    {
        $cat = $request->get('cat') ?? null;
        if ($cat) {
            $category = Category::where('id', $cat)->first();
        }
        $count = 15;
        $post_type = str_singular($post_type);
        $query = Post::where('type', $post_type)
            ->where('status', 'publish')
            ->select(['id', 'title', 'body', 'excerpt', 'format', 'type']);
        if ($post_type == 'exercise' && $this->userType == 'premium') {
            $user = JWTAuth::toUser();
            $lastExerciseTimestamp = $user->metaFor('user_last_exercise_timestamp');
            $lastExerciseDate = Carbon::createFromTimestamp($lastExerciseTimestamp->value);
            $exerciseCount = $user->metaFor('user_exercise_count');
            $exerciseLevel = $user->metaFor('user_exercise_level');
            $now = Carbon::now();
            if ($exerciseLevel->value < $category->order) {
                return response()->json(['error' => 'this_level_is_locked_for_you'], 401);
            }
            if ($exerciseLevel->value == $category->order) {
                if ($lastExerciseDate->diffInDays($now) == 0) {
                    $count = $exerciseCount->value - 1;
                } else {
                    $count = $exerciseCount->value;
                }
                $lastPost = Post::where('type', 'exercise')
                    ->where('status', 'publish')
                    ->whereHas('categories', function($query) use ($category) {
                        $query->where('category_id', $category->id);
                    })->oldest()->skip($count - 1)->take(1)->first();
                $query->where('created_at', '<=', $lastPost->created_at);
            }
        }
        if ($post_type == 'exercise') {
            $query->oldest();
        } else {
            $query->latest();
        }
        $country = $request->get('country') ?? null;
        if ($this->userType == 'free') {
            $query->where('access', 'free');
        }
        if ($cat) {
            $query->whereHas('categories', function ($query) use ($cat) {
                $query->where('category_id', $cat);
            });
        }
        if ($country) {
            $query->whereHas('metas', function ($query) use ($country) {
                $query->where('value', $country);
            });
        }
        $posts = $query->with([
            'categories' => function ($query) {
                $query->select(['categories.id', 'title', 'type', 'description', 'order']);
            }, 'mainAttachment.children', 'metas'])->paginate($count);
        $this->preparePostsResponse($posts);
        return response()->json($posts, 200);
    }

    private function preparePostsResponse($posts)
    {
        foreach ($posts as $post) {
            $this->preparePost($post);
        }
    }

    private function preparePost(Post $post)
    {
        $categories = $post->categories;
        $categories->each(function ($category) {
            $category->addTranslationItem('category_title', $category->trans('category_title') ?? "");
//            $categoryTranslations = $category->translations;
//            $categoryTitle = $categoryTranslations->filter(function ($translation) {
//                return $translation->translation_key == 'category_title';
//            })->first();
//            $category->translation = [
//                'category_title' => $categoryTitle ? $categoryTitle->translation_value : '',
//            ];
//            unset($category->translations);
        });


        $post->addTranslationItem('post_title', $post->trans('post_title') ?? "");
        $post->addTranslationItem('post_body', $post->trans('post_body') ?? "");
        $post->addTranslationItem('post_excerpt', $post->trans('post_excerpt') ?? "");

        $main = $post->mainAttachment;
        if (!$main->isEmpty()) {
            $main = $main[0];
            $children = $main->children;
            $attachmentPath = $main->type == 'external_youtube' ? $main->path : url('/uploads/' . $main->path);
            $post->attachment = [
                'type' => $main->type,
                'path' => $attachmentPath,
                'size' => "0",
            ];
            $thumbs = [
                'medium' => [
                    'type' => 'thumbnail',
                    'path' => url('/uploads/' . $children[0]->path),
                    'size' => $children[0]->size,
                ],
                'sq-small' => [
                    'type' => 'thumbnail',
                    'path' => url('/uploads/' . $children[2]->path),
                    'size' => $children[2]->size,
                ],
                'small' => [
                    'type' => 'thumbnail',
                    'path' => url('/uploads/' . $children[1]->path),
                    'size' => $children[1]->size,
                ]
            ];
            $post->thumbnails = $thumbs;
        }
        unset($post->mainAttachment);

        $metas = $post->metas->keyBy('key');
        $ms = [];
        foreach ($metas as $key => $meta) {
            $ms[$key] = $meta->value;
        }
        unset($post->metas);
        $post->metas = $ms;
    }

    public function single($postId)
    {
        $post = Post::where('id', $postId)
            ->select(['id', 'title', 'body', 'excerpt', 'format', 'type', 'created_at'])
            ->with(['categories' => function ($query) {
                $query->select(['categories.id', 'title', 'type', 'description', 'order']);
            }, 'mainAttachment.children'])
            ->first();

        if ($post->type == 'exercise' && $this->userType == 'premium') {
            $user = JWTAuth::toUser();
            $lastExerciseTimestamp = $user->metaFor('user_last_exercise_timestamp')->value;
            $exerciseCount = $user->metaFor('user_exercise_count')->value;
            $exerciseLevel = $user->metaFor('user_exercise_level')->value;
            $category = Category::where('type', 'exercise_cat')->where('order', $exerciseLevel)->first();

            if ($category) {
                $levelExerciseCount = Post::where('type', 'exercise')
                    ->where('status', 'publish')
                    ->whereHas('categories', function ($query) use ($category) {
                        $query->where('category_id', $category->id);
                    })->count();
                $now = Carbon::now();

                $postsBefore = Post::where('type', 'exercise')
                    ->where('status', 'publish')
                    ->where('created_at', '<', $post->created_at)
                    ->whereHas('categories', function ($query) use ($category) {
                        $query->where('category_id', $category->id);
                    })->count();

                \Log::info("Level Exercise count : $exerciseLevel, Level: $exerciseLevel, Count: $exerciseCount, Posts Before: $postsBefore, Category Id: $category->id");

                if (!$post->categories->isEmpty() && $post->categories[0]->order == $exerciseLevel) {
                    \Log::info('tertyey');
                    if ($exerciseCount == $postsBefore + 1) {
                        if ($levelExerciseCount == $exerciseCount) {
                            $user->addOrUpdateMeta('user_last_exercise_timestamp', $now->timestamp);
                            $user->addOrUpdateMeta('user_exercise_count', 1);
                            $user->addOrUpdateMeta('user_exercise_level', $exerciseLevel + 1);
                            $post->next_video_opened = "level";
                        } elseif ($levelExerciseCount > $exerciseCount) {
                            $user->addOrUpdateMeta('user_last_exercise_timestamp', $now->timestamp);
                            $user->addOrUpdateMeta('user_exercise_count', $exerciseCount + 1);
                            $post->next_video_opened = "video";
                        }
                    }
                }
            }
        }

        if (!$post) {
            return response()->json(['error' => 'post_not_found'], 404);
        }

        $this->preparePost($post);
        return response()->json($post);
    }

}
