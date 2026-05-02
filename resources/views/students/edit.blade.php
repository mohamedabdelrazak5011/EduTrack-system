@extends('layouts.app')

@section('title', 'تعديل طالب')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header bg-warning">
                ✏️ تعديل بيانات الطالب
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('students.update', $student->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="text" name="name" value="{{ $student->name }}" class="form-control mb-2"
                        placeholder="اسم الطالب">

                    <input type="text" name="parent_phone" value="{{ $student->parent_phone }}" class="form-control mb-2"
                        placeholder="رقم ولي الأمر">

                    <select name="center_id" class="form-control mb-2">

                        @foreach($centers as $center)
                            <option value="{{ $center->id }}" {{ $student->center_id == $center->id ? 'selected' : '' }}>
                                {{ $center->name }}
                            </option>
                        @endforeach

                    </select>

                    <button class="btn btn-success w-100">
                        💾 حفظ التعديل
                    </button>

                </form>

            </div>
        </div>

    </div>

@endsection