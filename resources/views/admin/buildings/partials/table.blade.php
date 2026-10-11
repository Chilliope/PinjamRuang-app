<table>
    <thead>
        <tr>
            <th>Major</th>
            <th>Building Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($buildings as $building)
            <tr>
                <td>
                    @forelse ($building->majors as $major)
                        <a href="/admin/majors/{{ $major->id }}">
                            {{ $major->major }}
                        </a>
                    @empty
                        Universal
                    @endforelse
                </td>
                <td>
                    {{ $building->building_name }}
                </td>
                <td>
                    <a href="/admin/buildings/{{ $building->id }}/edit">
                        Edit
                    </a>

                    <form
                        action="/admin/buildings/{{ $building->id }}"
                        method="POST"
                    >
                        @csrf
                        @method('delete')

                        <button
                            type="submit"
                            onclick="return confirm('Delete?')"
                        >
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2">Major tidak ditemukan.</td>
            </tr>
        @endforelse
    </tbody>
</table>
