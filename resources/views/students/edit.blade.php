@extends('layouts.app')

@section('title', 'تعديل طالب')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header bg-warning fw-bold">
            ✏️ تعديل بيانات الطالب
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('students.update', $student->id) }}">
                @csrf
                @method('PUT')

                {{-- الاسم --}}
                <div class="mb-3">
                    <label class="form-label">👤 اسم الطالب</label>
                    <input type="text" name="name" value="{{ $student->name }}" class="form-control" readonly>
                </div>

                {{-- رقم ولي الأمر --}}
                <div class="mb-3">
                    <label class="form-label">📞 رقم ولي الأمر</label>
                    <input type="text" name="parent_phone" value="{{ $student->parent_phone }}" class="form-control">
                </div>

                {{-- رقم الطالب --}}
                <div class="mb-3">
                    <label class="form-label">📱 رقم الطالب</label>
                    <input type="text" name="phone" value="{{ $student->phone }}" class="form-control">
                </div>

                {{-- الصف --}}
                <div class="mb-3">
                    <label class="form-label">🏫 الصف الدراسي</label>
                    <select name="grade" class="form-control">

                        <option value="">اختر الصف</option>

                        <option value="prep_1" {{ $student->grade == 'prep_1' ? 'selected' : '' }}>أولى إعدادي</option>
                        <option value="prep_2" {{ $student->grade == 'prep_2' ? 'selected' : '' }}>ثانية إعدادي</option>
                        <option value="prep_3" {{ $student->grade == 'prep_3' ? 'selected' : '' }}>ثالثة إعدادي</option>

                        <option value="sec_1" {{ $student->grade == 'sec_1' ? 'selected' : '' }}>أولى ثانوي</option>
                        <option value="sec_2" {{ $student->grade == 'sec_2' ? 'selected' : '' }}>ثانية ثانوي</option>
                        <option value="sec_3" {{ $student->grade == 'sec_3' ? 'selected' : '' }}>ثالثة ثانوي</option>

                    </select>
                </div>

                {{-- المركز --}}
                <div class="mb-3">
                    <label class="form-label">🏢 المركز</label>
                    <select name="center_id" class="form-control">

                        @foreach($centers as $center)
                            <option value="{{ $center->id }}"
                                {{ $student->center_id == $center->id ? 'selected' : '' }}>
                                {{ $center->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- تاريخ الميلاد --}}
                <div class="mb-3">
                    <label class="form-label">📅 تاريخ الميلاد</label>
                    <input type="date" name="birth_date" value="{{ $student->birth_date }}" class="form-control">
                </div>

               
                <button class="btn btn-success w-100">
                    💾 حفظ التعديل
                </button>

            </form>

        </div>

    </div>

</div>

@endsection