<div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Transaction Information</h3>
            <p class="text-muted m-b-30 font-13">Enter transaction Information</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                        <label class="control-label" for="amount">Amount</label>
                        <input type="text" name="amount" class="form-control" placeholder="amount" value="{{ $program->amount or '' }}">
                        @if($errors->has('amount'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </div>
                        @endif
                    </div>


                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        <label class="control-label" for="type">Transaction Type</label>
                        <select name="type" class="form-control">
                            <option {{ (isset($program) && $program->type == 'income') ? 'selected' : '' }} value="income">Income</option>
                            <option {{ (isset($program) && $program->type == 'expense') ? 'selected' : '' }} value="expense">Expense</option>
                        </select>
                        @if($errors->has('type'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('type') }}</strong>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success btn-block">{{ $isEdit ? 'Update' : 'Submit' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>