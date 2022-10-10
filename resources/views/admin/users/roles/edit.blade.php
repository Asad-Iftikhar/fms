@extends('admin.layouts.default')
@section('title', 'User Roles')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        Create Role
                    </div>
                    <div class="col-6">
                        <span>
                            <a href="{{url('admin/roles')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" id="basicInput" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3">
                        <label>Role Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3">
                        <label>Permission</label>
                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <select class="choices form-select multiple-remove" multiple="multiple">
                                    <option value="romboid">Romboid</option>
                                    <option value="trapeze" selected>Trapeze</option>
                                    <option value="triangle">Triangle</option>
                                    <option value="polygon">Polygon</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Update</button>
            </div>
        </div>
    </section>
@section('javascript')

@stop
@stop
