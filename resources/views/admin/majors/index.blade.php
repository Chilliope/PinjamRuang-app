@extends('layouts.admin')

@section('content')
    <div class="mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
                    Majors
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage the majors available in your application.
                </p>
            </div>

            <a href="{{ route('majors.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>

                Add major
            </a>
        </div>

        {{-- Search --}}
        <form action="{{ route('majors.index') }}" method="GET">
            <div class="relative max-w-md">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>

                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search majors..."
                    autocomplete="off"
                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-400 focus:ring-4 focus:ring-gray-100">
            </div>
        </form>

        {{-- Major cards --}}
        @if ($majors->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($majors as $major)
                    <article
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md">
                        <div class="flex items-start justify-between gap-4">
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                    stroke-linejoin="round" aria-hidden="true">
                                    <path d="m22 10-10-5L2 10l10 5 10-5Z" />
                                    <path d="M6 12v5c3.5 3 8.5 3 12 0v-5" />
                                    <path d="M22 10v6" />
                                </svg>
                            </div>

                            <span class="rounded-full border border-gray-200 px-2.5 py-1 text-xs font-medium text-gray-500">
                                Major #{{ $major->id }}
                            </span>
                        </div>

                        <div class="mt-5">
                            <h2 class="text-base font-semibold text-gray-900">
                                {{ $major->major }}
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Manage this major and its associated buildings.
                            </p>
                        </div>


                        {{-- Major information --}}
                        <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="text-xs text-gray-400">
                                Major information
                            </span>

                            <div class="flex items-center gap-1">
                                {{-- Edit Button --}}
                                <a href="{{ route('majors.edit', $major) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-950">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                    Edit
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('majors.destroy', $major) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus major {{ addslashes($major->major) }}? Data yang dihapus tidak dapat dikembalikan.')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($majors instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="pt-2">
                    {{ $majors->links() }}
                </div>
            @endif
        @else
            {{-- Empty state --}}
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">
                <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                </div>

                <h2 class="mt-4 text-base font-semibold text-gray-900">
                    No majors found
                </h2>

                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-500">
                    @if (request('search'))
                        No majors match "{{ request('search') }}".
                        Try another search keyword.
                    @else
                        Get started by creating your first major.
                    @endif
                </p>

                @if (request('search'))
                    <a href="{{ route('majors.index') }}"
                        class="mt-5 inline-flex items-center rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Clear search
                    </a>
                @else
                    <a href="{{ route('majors.create') }}"
                        class="mt-5 inline-flex items-center rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-700">
                        Create your first major
                    </a>
                @endif
            </div>
        @endif

    </div>
@endsection
