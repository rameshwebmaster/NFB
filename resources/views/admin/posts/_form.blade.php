<div class="row">
    <div class="col-md-8">

        <div class="white-box">
            <h3 class="box-title m-b-0">English Details</h3>
            <p class="text-muted m-b-20">Enter required details in English</p>

            {{--Title Field--}}
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="control-label">Title</label>
                <input type="text" name="title" class="form-control" placeholder="title"
                       value="{{ $isEdit ? $post->title : old('title') }}">
                @if($errors->has('title'))
                    <div class="help-block with-errors">
                        <ul class="list-unstyled">
                            <strong>{{ $errors->first('email') }}</strong>
                        </ul>
                    </div>
                @endif
            </div>
            {{--End of Title Field--}}


            @if($postType != 'companies')
                {{--Body Field--}}
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea name="body" id="body" placeholder="Enter the post body"
                              class="form-control">{{ $isEdit ? $post->body : old('body') }}</textarea>
                </div>
                {{--End of Body Field--}}
            @endif


            @if($postType != 'companies')
                {{--Excerpt Field--}}
                <div class="form-group">
                    <label for="excerpt">Excerpt</label>
                    <textarea name="excerpt" placeholder="Enter the post excerpt"
                              class="form-control">{{ $isEdit ? $post->excerpt : old('excerpt') }}</textarea>
                </div>
                {{--End of Excerpt Field--}}
            @endif

        </div>

        <div class="white-box">
            <h3 class="box-title m-b-0">Arabic Details</h3>
            <p class="text-muted m-b-20">Enter required details in Arabic</p>

            {{--Title Field--}}
            <div class="form-group{{ $errors->has('arabic_title') ? ' has-error' : '' }}">
                <label for="arabic_title" class="control-label">Title</label>
                <input type="text" name="arabic_title" class="form-control input-rtl" placeholder="title"
                       value="{{ $isEdit ? $post->trans('post_title') : old('arabic_title') }}">
                @if($errors->has('arabic_title'))
                    <div class="help-block with-errors">
                        <strong>{{ $errors->first('arabic_title') }}</strong>
                    </div>
                @endif
            </div>
            {{--End of Title Field--}}


            @if($postType != 'companies')
                {{--Body Field--}}
                <div class="form-group">
                    <label for="arabic_body">Body</label>
                    <textarea name="arabic_body" id="arabic_body" placeholder="Enter the post body"
                              class="form-control">{{ $isEdit ? $post->trans('post_body') : old('arabic_body') }}</textarea>
                </div>
                {{--End of Body Field--}}
            @endif


            @if($postType != 'companies')
                {{--Excerpt Field--}}
                <div class="form-group">
                    <label for="arabic_excerpt">Excerpt</label>
                    <textarea name="arabic_excerpt" id="arabic_excerpt" placeholder="Enter the post excerpt"
                              class="form-control">{{ $isEdit ? $post->trans('post_excerpt') : old('arabic_excerpt') }}</textarea>
                </div>
                {{--End of Excerpt Field--}}
            @endif

        </div>

        @if($postType == 'companies')
            <div class="white-box">
                <h4 class="box-title m-b-20">Meta Information</h4>
                <div class="row">
                    <div class="col-xs-12 form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="instagram_id">Instagram ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="instagram_id" id="instagram_id"
                                       placeholder="Enter Instagram ID"
                                       value="{{ isset($post->getMeta('instagram_id')) ? $post->getMeta('instagram_id') : old('instagram_id') }}">  <?php //{{ $post->getMeta('instagram_id') ?? old('instagram_id') }} ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="phone_number">Phone Number:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone_number" id="phone_number"
                                       placeholder="Enter Phone Number"
                                       value="{{ isset($post->getMeta('phone_number')) ? $post->getMeta('phone_number') : old('phone_number') }}"> <?php //{{ $post->getMeta('phone_number') ?? old('phone_number') }} ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address">Address:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="address" id="address"
                                       placeholder="Enter Address"
                                       value="{{ isset($post->getMeta('address')) ? $post->getMeta('address') : old('address') }}"> <?php //$post->getMeta('address') ?? old('address') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="website">Website:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="website" id="website"
                                       placeholder="Enter Website"
                                       value="{{ isset($post->getMeta('website')) ? $post->getMeta('website') : old('website') }}"> <?php //{{ $post->getMeta('website') ?? old('website') }} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <div class="col-md-4">

        @if($postType != 'companies')
            <div class="white-box">
                <h4 class="box-title m-b-0">Details</h4>
                <p class="text-muted m-b-20">Post Details</p>
                <div class="row">
                    <div class="col-sm-12">
                        {{--Format Field--}}
                        <div class="form-group">
                            <label>Format</label>
                            <div class="btn-group btn-group-justified format-btn-group">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary standard-format"
                                            data-format="standard">Standard
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-outline video-format"
                                            data-format="video">Video
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="format" class="format-input" value="standard">
                        </div>
                        {{--End of Format Field--}}

                        {{--Access Field--}}
                        <div class="form-group">
                            <label>Access</label>
                            <div class="radio-list">
                                <label class="radio">
                                    <div class="radio radio-info">
                                        <input type="radio" name="access" value="free"
                                               id="free" {{ $isEdit ? ($post->access == 'free' ? 'checked' : '') : 'checked' }}>
                                        <label for="free">Free</label>
                                    </div>
                                </label>
                                <label class="radio-inline">
                                    <div class="radio radio-info">
                                        <input type="radio" name="access" value="premium"
                                               id="premium" {{ $isEdit ? ($post->access == 'premium' ? 'checked' : '') : '' }}>
                                        <label for="premium">Premium</label>
                                    </div>
                                </label>
                            </div>
                        </div>
                        {{--End of Access Field--}}


                    </div>
                </div>
            </div>
        @endif


        {{--@if($isEdit)--}}
            {{--<div class="white-box">--}}
                {{--<h4 class="box-title m-b-20">Translations</h4>--}}

                {{--Translation Button--}}
                {{--<a href="{{ route('translatePost', ['postType' => $postType, 'post' => $post->id]) }}"--}}
                   {{--class="btn btn-warning">Arabic Translation</a>--}}
                {{--End of Translation Button--}}

            {{--</div>--}}
        {{--@endif--}}

        <div class="white-box">
            <h3 class="box-title m-b-0">Category</h3>
            <p class="text-muted m-b-20">Choose your category</p>
            <div class="row">

                {{--Category Section--}}
                <div class="col-xs-12">
                    @foreach($categories as $category)
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" value="{{ $category->id }}" name="category[]"
                                   id="category-{{ $category->id }}"
                            @if($isEdit)
                                @foreach($post->categories as $pcategory)
                                    {{ $pcategory->id == $category->id ? 'checked' : '' }}
                                        @endforeach
                                    @endif
                            >
                            <label for="category-{{ $category->id }}">{{ $category->title }}</label>
                        </div>
                    @endforeach
                </div>
                {{--End of Category Section--}}
            </div>
        </div>


        @if($postType == 'companies')
            <div class="white-box">
                <h3 class="box-title m-b-0">Country</h3>
                <p class="text-muted m-b-20">Choose your country</p>
                <div class="row">
                    <div class="col-xs-12">
                        {{--Country Field--}}
                        <select name="country" id="country" class="form-control">
                            @foreach($countries as $key => $country)
                                <option value="{{ $key }}"
                                @if($post->getMeta('country'))
                                    {{ $post->getMeta('country') == $key ? 'selected' : '' }}
                                        @endif
                                >{{ $country }}</option>
                            @endforeach
                        </select>
                        {{--End of Country Field--}}
                    </div>
                </div>
            </div>
        @endif

        <div class="white-box attachment-box">
            <h4 class="box-title m-b-0">Thumbnail</h4>
            <p class="text-muted m-b-20 attachment-desc">Choose thumbnail</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 col-sm-offset-3">
                            <img class="img-responsive img thumb-image img-thumbnail"
                            @if($isEdit)
                                {{--                                         {{ dd($post->mainAttachment->isEmpty()) }}--}}
                                        {{ 'src=' . ($post->mainAttachment->isEmpty() ? '' :  '/uploads/' . $post->mainAttachment[0]->squareSmall->path) }}
                                    @endif>
                        </div>
                    </div>
                    <button type="button" class="btn btn-info btn-block m-t-5" id="attachment-dialog-trigger">Choose
                    </button>
                    <input type="hidden" name="attachment" value="{{ $post->mainAttachment[0]->id or '' }}"
                           id="attachment">
                    <input type="hidden" name="attachment_type" id="attachment_type" value="thumbnail">
                </div>
            </div>
        </div>

        <div class="white-box">
            <button type="submit" class="btn btn-success btn-block">{{ $isEdit ? 'Update' : 'Publish' }}</button>
        </div>
    </div>
</div>