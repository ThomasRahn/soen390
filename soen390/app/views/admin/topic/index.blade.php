@extends('admin.master')

@section('view_title')
{{ trans('admin.sidebar.topics') }}
@stop

@section('styles')
<style>
    th {
        font-weight: 400;
        cursor: pointer;
    }
</style>
@stop

@section('content')
<table class="table topics-table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.topic.index.table.code') }}</th>
            <th>{{ trans('admin.topic.index.table.description') }}</th>
            <th>{{ trans('admin.topic.index.table.narratives') }}</th>
            <th>{{ trans('admin.topic.index.table.manage') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($topics) === 0)
        <tr>
            <td colspan="4">{{ trans('admin.topic.index.table.empty') }}</td>
        </tr>
        @else
        @foreach ($topics as $t)
        <tr data-topic-id="{{{ $t->id }}}">
            <td class="topic-id">{{{ $t->id }}}</td>
            <td class="topic-code"><code>{{{ $t->code }}}</code></td>
            <td class="topic-description">{{{ $t->description }}}</td>
            <td class="topic-narratives">{{{ $t->narratives }}}</td>
            <td>
                <div class="btn-group btn-group-xs">
                    <button class="btn btn-default"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-default"><i class="fa fa-trash-o"></i></button>
                </div>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
@stop

@section('scripts')
@stop