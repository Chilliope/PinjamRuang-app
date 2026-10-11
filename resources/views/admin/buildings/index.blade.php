@extends('layouts.admin')

@section('title', 'Buildings - Pinjam Ruang')

@section('content')
    <h1>Buildings</h1>

    <a href="/admin/buildings/create">Create</a>

    <form id="search-form">
        <input type="search" id="search" name="search" placeholder="Search building..." autocomplete="off">
    </form>

    <div id="building-table">
        @include('admin.buildings.partials.table')
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const buildingTable = document.getElementById('building-table');

        let timeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);

            timeout = setTimeout(async () => {
                const params = new URLSearchParams({
                    search: searchInput.value
                });

                try {
                    const response = await fetch(
                        `/admin/buildings?${params}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data buildings');
                    }

                    buildingTable.innerHTML = await response.text();
                } catch (error) {
                    console.error(error);
                }
            }, 300);
        });
    </script>
@endsection
