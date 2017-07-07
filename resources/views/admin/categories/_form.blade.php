<div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Category Information</h3>
            <p class="text-muted m-b-30 font-13">Enter category Information</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label class="control-label" for="title">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title"
                               value="{{ $category->title or '' }}">
                        @if($errors->has('title'))
                            <div class="help-block with-errors">
                                <div class="help-block with-errors">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </div>
                            </div>
                        @endif

                    </div>


                    <div class="form-group {{ $errors->has('arabic_title') ? 'has-error' : '' }}">
                        <label class="control-label" for="arabic_title">Arabic Title</label>
                        <input type="text" name="arabic_title" class="form-control input-rtl" placeholder="Arabic Title"
                               value="{{ isset($category) ? $category->trans('category_title') : old('arabic_title') }}">
                        @if($errors->has('arabic_title'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_title') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">--}}
                    {{--<label class="control-label" for="slug">Slug</label>--}}
                    {{--<input type="text" name="slug" class="form-control" placeholder="slug" value="{{ $category->slug or '' }}">--}}
                    {{--@if($errors->has('slug'))--}}
                    {{--<div class="help-block with-errors">--}}
                    {{--<strong>{{ $errors->first('slug') }}</strong>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--</div>--}}

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label class="control-label" for="description">Description</label>
                        <textarea name="description" id="description"
                                  rows="10" class="form-control">{{ $category->description or '' }}</textarea>
                        @if($errors->has('description'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('description') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('arabic_description') ? 'has-error' : '' }}">
                        <label class="control-label" for="arabic_description">Arabic Description</label>
                        <textarea name="arabic_description" id="arabic_description"
                                  rows="10"
                                  class="form-control input-rtl">{{ isset($category) ? $category->trans('category_description') : old('arabic_description') }}</textarea>
                        @if($errors->has('arabic_description'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_description') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="order">Order</label>
                        <select name="order" id="order" class="form-control">
                            <option value="0">No order</option>
                            @foreach(range(1,50) as $order)
                                @if(isset($category))
                                    @unless(in_array($order, $usedOrders) && $order != $category->order)
                                        <option value="{{ $order }}" {{ isset($category) && $category->order == $order ? 'selected' : '' }}>{{ $order }}</option>
                                    @endunless
                                @else
                                    @unless(in_array($order, $usedOrders))
                                        <option value="{{ $order }}" {{ isset($category) && $category->order == $order ? 'selected' : '' }}>{{ $order }}</option>
                                    @endunless
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>