
@extends('layouts.admin')

@section('content')
    <h1>Majors</h1>

    <a href="/admin/majors/create">Create</a>

    <form id="search-form">
        <input
            type="search"
            id="search"
            name="search"
            placeholder="Search major..."
            autocomplete="off"
        >
    </form>

    <div id="major-table">
        @include('admin.majors.partials.table')
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const majorTable = document.getElementById('major-table');

        let timeout;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);

            timeout = setTimeout(async () => {
                const params = new URLSearchParams({
                    search: searchInput.value
                });

                try {
                    const response = await fetch(
                        `/admin/majors?${params}`,
                        {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data majors');
                    }

                    majorTable.innerHTML = await response.text();
                } catch (error) {
                    console.error(error);
                }
            }, 300);
        });
    </script>
@endsection
