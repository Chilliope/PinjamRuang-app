<table>
    <thead>
        <tr>
            <th>Major</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($majors as $major)
            <tr>
                <td>
                    <a href="/admin/majors/{{ $major->id }}">
                        {{ $major->major }}
                    </a>
                </td>

                <td>
                    <a href="/admin/majors/{{ $major->id }}/edit">
                        Edit
                    </a>

                    <form
                        action="/admin/majors/{{ $major->id }}"
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
