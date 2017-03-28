@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Show Note -
                        <i class="fa fa-{{$note->font_awesome->value}}" style="color: {{ $note->color->value }}"></i>
                        <i class="fa fa-{{ $note->encrypted ? 'lock' : 'unlock' }}"></i>
                        {{ $note->title }}

                        <span class="pull-right">
                            <a class="btn btn-primary btn-xs" title="edit"
                               href="{{ route('note.edit', ['note' => $note->id ]) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-xs" title="delete"
                               href="{{ route('note.destroy', ['note' => $note->id ]) }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                    </div>

                    <div class="panel-body" style="word-wrap: break-word;">

                        @if($note->encrypted)
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ route('note.show', ['note' => $note->id]) }}">

                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-3 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password"
                                               value="{{ old('password') }}" required autofocus>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">
                                            Decode
                                        </button>
                                    </div>
                                </div>

                            </form>
                        @else
                            {!! $note->text  !!}
                            <div class="clearfix"></div>
                            <i>created at: {{ $note->created_at }}</i>
                            <div class="clearfix"></div>
                            <i>updated at: {{ $note->updated_at }}</i>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
