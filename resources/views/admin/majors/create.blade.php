
@extends('layouts.admin')

@section('title', 'Create Major - PinjamRuang')
@section('page-title', 'Create Major')
@section('breadcrumb', 'Majors / Create')

@section('heading')
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <div class="mb-3 flex items-center gap-2 text-xs font-medium text-slate-400">
                <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                <span>Academic Management</span>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-indigo-600">Create Major</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Create Major
            </h1>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Add a new academic major to the PinjamRuang system.
            </p>
        </div>

        <a href="{{ route('majors.index') }}"
            class="inline-flex items-center justify-center gap-2 self-start rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 sm:self-auto">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Back to Majors
        </a>
    </div>
@endsection

@section('content')

    {{-- Form Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

        {{-- Card Header --}}
        <div class="flex items-center gap-4 border-b border-slate-100 px-6 py-5 sm:px-8">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            </div>

            <div>
                <h2 class="text-base font-bold text-slate-900">
                    Major Information
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Enter the details for the new major below.
                </p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ url('/admin/majors') }}" method="POST">
            @csrf

            <div class="space-y-6 px-6 py-7 sm:px-8">

                {{-- Major Name --}}
                <div>
                    <label for="major"
                        class="mb-2 block text-sm font-semibold text-slate-700">
                        Major Name
                        <span class="text-rose-500">*</span>
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <i data-lucide="book-open"
                                class="h-[18px] w-[18px] text-slate-400"></i>
                        </div>

                        <input
                            type="text"
                            id="major"
                            name="major"
                            value="{{ old('major') }}"
                            placeholder="e.g. Information Systems"
                            required
                            autofocus
                            class="w-full rounded-xl border bg-white py-3 pl-11 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 {{ $errors->has('major') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/10' : 'border-slate-200 hover:border-slate-300' }}">

                    </div>

                    @error('major')
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                            <i data-lucide="alert-circle" class="h-4 w-4"></i>
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-2 text-xs text-slate-400">
                        Enter the full name of the academic major.
                    </p>
                </div>

                {{-- Information Note --}}
                <div class="flex items-start gap-3 rounded-xl border border-indigo-100 bg-indigo-50/60 p-4">
                    <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600"></i>

                    <p class="text-xs leading-5 text-slate-600">
                        Make sure the major name is correct before saving. The information will be added to the system after submission.
                    </p>
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-5 sm:flex-row sm:items-center sm:justify-end sm:px-8">

                <a href="{{ route('majors.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/20">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Create Major
                </button>

            </div>
        </form>
    </div>

@endsection
