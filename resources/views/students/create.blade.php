@extends('layouts.app')

@section('title', 'إضافة طالب')

@section('content')

    <div class="container">

        <div class="card col-md-8 mx-auto">
            <div class="card-header bg-primary text-white fw-bold">
                ➕ إضافة طالب جديد
            </div>

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">


                        {{-- اسم الطالب --}}
                        <div class="col-md-6">
                            <label class="form-label">اسم الطالب *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        {{-- رقم ولي الأمر --}}
                        <div class="col-md-6">
                            <label class="form-label">رقم ولي الأمر *</label>
                            <input type="text" name="parent_phone" class="form-control" value="{{ old('parent_phone') }}"
                                required>
                        </div>

                        {{-- النوع (اختيار) --}}
                        <div class="col-md-6">
                            <label class="form-label">النوع</label>
                            <select name="gender" class="form-select">
                                <option value="">اختر النوع</option>
                                <option value="male">ولد</option>
                                <option value="female">بنت</option>
                            </select>
                        </div>

                        {{-- الصف الدراسي --}}
                        <div class="col-md-6">
                            <label class="form-label">الصف الدراسي</label>
                            <select name="grade" class="form-select">
                                <option value="">اختر الصف</option>



                                <option value="prep_1">أولى إعدادي</option>
                                <option value="prep_2">ثانية إعدادي</option>
                                <option value="prep_3">ثالثة إعدادي</option>

                                <option value="sec_1">أولى ثانوي</option>
                                <option value="sec_2">ثانية ثانوي</option>
                                <option value="sec_3">ثالثة ثانوي</option>

                            </select>
                        </div>

                        {{-- المركز --}}
                        <div class="col-md-6">
                            <label class="form-label">المركز</label>
                            <select name="center_id" class="form-select" required>
                                <option value="">-- اختر المركز --</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- الحالة --}}
                        <div class="col-md-6">
                            <label class="form-label">حالة الطالب</label>
                            <select name="status" class="form-select">
                                <option value="active">نشط</option>
                                <option value="inactive">غير نشط</option>
                            </select>
                        </div>

                        {{-- رقم الطالب (اختياري) --}}
                        <div class="col-md-6">
                            <label class="form-label">رقم الطالب</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        {{-- تاريخ الميلاد --}}
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الميلاد</label>
                            <input type="date" name="birth_date" class="form-control">
                        </div>

                        {{-- الصورة --}}
                        <div class="col-md-12">
                            <label class="form-label">صورة الطالب</label>
                            <input type="file" name="photo" class="form-control">
                        </div>

                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">
                            رجوع
                        </a>

                        <button class="btn btn-success px-4">
                            حفظ الطالب
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection