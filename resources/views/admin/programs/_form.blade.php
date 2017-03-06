<div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Program Information</h3>
            <p class="text-muted m-b-30 font-13">Enter program Information</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label class="control-label" for="title">Program Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title"
                               value="{{ $program->title or '' }}">
                        @if($errors->has('title'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                        @endif
                    </div>

                    <?php
                    $bmis = [
                        'Less than 16 (Severe Thinness)',
                        '16 - 17 (Moderate Thinness)',
                        '17 - 18.5 (Mild Thinness)',
                        '18.5 - 25 (Normal)',
                        '25 - 30 (Overweight)',
                        '30 - 35 (Obese Class I)',
                        '35 - 40 (Obese Class II)',
                        'More than 40 (Obese Class III)',
                    ];
                    ?>
                    <div class="form-group">
                        <label for="bmi">BMI</label>
                        <select name="bmi" id="bmi" class="form-control">
                            @foreach($bmis as $bmi => $bmiTitle)
                                <option value="{{ $bmi }}"
                                @if(isset($program) && $program->bmi == $bmi)
                                    {{ 'selected' }}
                                        @endif
                                >{{ $bmiTitle }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="diseases">Diseases</label>
                        <?php $diseases = ['Diabetes', 'Blood pressure', 'Anemia', 'Urine Acid', 'Cholesterol'] ?>
                        @if(isset($program))
                            <?php $programDiseases = explode(',', $program->diseases); ?>
                        @endif
                        @foreach($diseases as $id => $disease)
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" value="{{ $id }}" name="disease[]"
                                       id="disease-{{ $id }}"
                                @if(isset($program) && $programDiseases[$id] == '1')
                                    {{ 'checked' }}
                                        @endif>
                                <label for="disease-{{ $id }}">{{ $disease }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="level">Nutrition Level</label>
                        <select name="level" id="level" class="form-control">
                            @foreach(range(1,50) as $level)

                                <option value="{{ $level }}"
                                @if(isset($program) && $program->level == $level)
                                    {{ 'selected' }}
                                        @endif
                                >Level {{ $level }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">{{ $isEdit ? 'Update' : 'Submit' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>