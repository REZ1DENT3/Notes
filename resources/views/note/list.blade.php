@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('note.create') }}" class="pull-right btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            Add Note
                        </a>
                        Note List
                    </div>

                    <div class="panel-body">

                        {{ $pager->links() }}

                        <table class="table">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="width: 45%">Title</th>
                                    <th>Update At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody class="table-striped">
                                @forelse ($pager as $note)
                                    <tr>
                                        <td>{{ $note->id }}</td>
                                        <td>
                                            <i class="fa fa-{{$note->font_awesome->value}}" style="color: {{ $note->color->value }}"></i>
                                            <i class="fa fa-{{ $note->encrypted ? 'lock' : 'unlock' }}"></i>
                                            {{ $note->title }}
                                        </td>
                                        <td>{{ $note->updated_at }}</td>
                                        <td>
                                            <a class="btn btn-info btn-xs" title="preview"
                                               href="{{ route('note.show', ['note' => $note->id ]) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-primary btn-xs" title="edit"
                                               href="{{ route('note.edit', ['note' => $note->id ]) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-xs note-trash" title="delete"
                                               href="{{ route('note.destroy', ['note' => $note->id ]) }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h3>No notes</h3>
                                            <a class="btn btn-primary" href="{{ route('note.create') }}">
                                                <i class="fa fa-plus"></i>
                                                Add Note
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
