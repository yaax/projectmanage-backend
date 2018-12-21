@extends('layouts.app')

@section('content')
    <div class="content-container">
        <div class="col-sm-offset-2 col-sm-8">
            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel-heading tasks-header">
                            משימות
                        </div>
                        <table class="table table-striped task-table">
                            <thead>
                                <th>משימה</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $key=>$task)
                                    <tr>
                                        <!-- Task Status Button -->
                                        <td>
                                            <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="delete">
                                                    X
                                                </button>
                                            </form>
                                        </td>
                                        <td class="table-text"><div>{{ intval($key+1).". ".$task->name }}</div></td>

                                        <!-- Task Delete Button -->
                                        <td class="delete-button">
                                            <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <label class="container">
                                                    {{ Form::checkbox('status',1,$task->status, array('id'=>'asap')) }}
                                                    <span class="checkmark"></span>
                                                </label>

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    משימה חדשה
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                    <form action="{{ url('task')}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">משימה</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
