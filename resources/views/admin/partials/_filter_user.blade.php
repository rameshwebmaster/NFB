<div class="form-group">
    <label for="country">Country</label>
    <select name="country" id="country" class="form-control">
        <option value="">Select Country</option>
        @foreach($countries as $code => $country)
            <option value="{{ $code }}">{{ $country }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Age</label>
    <div class="row">
        <div class="col-xs-6">
            <input type="text" class="form-control" name="age_from" placeholder="from">
        </div>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="age_to" placeholder="to">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" id="gender" class="form-control">
        <option value="">Choose</option>
        <option value="1">Male</option>
        <option value="2">Female</option>
    </select>
</div>
<div class="form-group">
    <label for="type">Account type</label>
    <select name="type" id="type" class="form-control">
        <option value="">Choose</option>
        <option value="gold">Gold</option>
        <option value="platinum">Platinum</option>
    </select>
</div>
<div class="form-group">
    <label>Diseases</label>
    <?php $diseases = ['Diabetes', 'Blood pressure', 'Anemia', 'Urine Acid', 'Cholesterol'] ?>
    @foreach($diseases as $id => $disease)
        <div class="checkbox checkbox-info">
            <input type="checkbox" value="{{ $id }}" name="disease[]"
                   id="disease-{{ $id }}">
            <label for="disease-{{ $id }}">{{ $disease }}</label>
        </div>
    @endforeach
</div>
<div class="form-group">
    <label for="blood_type">Blood Type</label>
    <?php $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] ?>
    <select name="blood_type" id="blood_type" class="form-control">
        <option value="">Choose</option>
        @foreach($blood_types as $blood_type)
            <option value="{{ $blood_type }}">{{ $blood_type }}</option>
        @endforeach
    </select>
</div>