<div class="form-group{{ $errors->has('newsletter') ? ' has-error' : '' }}">
    <div class="checkbox">
        <label>
            <input name="newsletter" type="checkbox" value="1" @checked(old('newsletter'))> Subscribe me to the BIIGLE newsletter.
        </label>
    </div>
    @if($errors->has('newsletter'))
        <span class="help-block">{{ $errors->first('newsletter') }}</span>
    @endif
</div>
