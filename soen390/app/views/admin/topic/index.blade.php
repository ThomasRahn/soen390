@extends('admin.master')

@section('view_title')
{{ trans('admin.sidebar.topics') }}
@stop

@section('styles')
@stop

@section('content')
<table class="table topics-table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.topics.table.code') }}</th>
            <th>{{ trans('admin.topics.table.description') }}</th>
            <th>{{ trans('admin.topics.table.narratives') }}</th>
            <th>{{ trans('admin.topics.table.manage') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($topics) === 0)
        <tr>
            <td colspan="4">{{ trans('admin.topics.table.empty') }}</td>
        </tr>
        @else
        @foreach ($topics as $t)
        <tr data-topic-id="{{{ $t->id }}}">
            <td>{{{ $t->id }}}</td>
            <td>{{{ $t->code }}}</td>
            <td>{{{ $t->description }}}</td>
            <td>{{{ $t->narratives }}}</td>
            <td>
                <a href="#"><i class="fa fa-fw fa-pencil"></i></a>
                <a href="#"><i class="fa fa-fw fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
@stop

@section('scripts')
@stop