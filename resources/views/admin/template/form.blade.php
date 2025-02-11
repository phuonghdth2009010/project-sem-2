@extends('admin.master')
@section('title')

@endsection
@section('custom_css')

@endsection
@section('content')
    <div class="row main-card mb-3 card">
        <div class="container">
            <div class="card-body"><h5 class="card-title">Grid</h5>
                <form class="">
                    <div class="position-relative row form-group"><label for="exampleEmail"
                                                                         class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10"><input name="email" id="exampleEmail" placeholder="with a placeholder"
                                                      type="email" class="form-control"></div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                                                                         class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10"><input name="password" id="examplePassword"
                                                      placeholder="password placeholder" type="password"
                                                      class="form-control"></div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleCustomSelect" class="col-sm-2 col-form-label">Custom Select</label>
                        <select type="select" id="exampleCustomSelect" name="customSelect"
                                class="custom-select col-sm-10">
                            <option value="">Select</option>
                            <option>Value 1</option>
                            <option>Value 2</option>
                            <option>Value 3</option>
                            <option>Value 4</option>
                            <option>Value 5</option>
                        </select>
                    </div>
                    <div class="position-relative row form-group"><label for="exampleSelectMulti"
                                                                         class="col-sm-2 col-form-label">Select
                            Multiple</label>
                        <div class="col-sm-10"><select multiple="" name="selectMulti" id="exampleSelectMulti"
                                                       class="form-control"></select></div>
                    </div>
                    <div class="position-relative row form-group"><label for="exampleText"
                                                                         class="col-sm-2 col-form-label">Text
                            Area</label>
                        <div class="col-sm-10"><textarea name="text" id="exampleText" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="exampleFile"
                                                                         class="col-sm-2 col-form-label">File</label>
                        <div class="col-sm-10"><input name="file" id="exampleFile" type="file"
                                                      class="form-control-file">
                            <small class="form-text text-muted">This is some placeholder block-level help text for the
                                above input. It's a bit lighter and easily wraps to a new line.</small>
                        </div>
                    </div>
                    <fieldset class="position-relative row form-group">
                        <legend class="col-form-label col-sm-2">Radio Buttons</legend>
                        <div class="col-sm-10">
                            <div class="position-relative form-check"><label class="form-check-label"><input
                                        name="radio2" type="radio" class="form-check-input"> Option one is this and
                                    that—be sure to include why it's great</label></div>
                            <div class="position-relative form-check"><label class="form-check-label"><input
                                        name="radio2" type="radio" class="form-check-input"> Option two can be something
                                    else and selecting it will deselect option
                                    one</label></div>
                            <div class="position-relative form-check disabled"><label class="form-check-label"><input
                                        name="radio2" disabled="" type="radio" class="form-check-input"> Option three is
                                    disabled</label></div>
                        </div>
                    </fieldset>
                    <div class="position-relative row form-group"><label for="checkbox2"
                                                                         class="col-sm-2 col-form-label">Checkbox</label>
                        <div class="col-sm-10">
                            <div class="position-relative form-check"><label class="form-check-label"><input
                                        id="checkbox2" type="checkbox" class="form-check-input"> Check me out</label>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative row form-check">
                        <div class="col-sm-10 offset-sm-2">
                            <button class="btn btn-secondary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_js')

@endsection

