@extends('layouts.app')

@section('title', 'إضافة طالب')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header bg-primary text-white">
                ➕ إضافة طالب جديد
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- الاسم (إجباري) --}}
                    <input type="text" name="name" class="form-control" placeholder="اسم الطالب" required>

                    {{-- ولي الأمر (إجباري) --}}
                    <input type="text" name="parent_phone" class="form-control" placeholder="رقم ولي الأمر" required>

                    {{-- صورة (إجباري) --}}
                    <input type="file" name="photo" class="form-control" required>

                    {{-- اختيار المركز --}}
                    <select name="center_id" class="form-control" required>
                        <option value="">-- اختر المركز --</option>
                        @foreach($centers as $center)
                            <option value="{{ $center->id }}">{{ $center->name }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-success w-100 mt-3">
                        حفظ الطالب
                    </button>
                </form>

            </div>
        </div>

    </div>

@endsection