<a href="{{ route('admin.users.edit', $id) }}">
    <x-button color="warning" type="submit"><i class="fas fa-edit"></i></x-button>
</a>

<x-form :action="route('admin.users.destroy', $id)" onsubmit="javascript:return confirm('Voulez-vous vraiment supprimer {{ $name }}?')" method="delete" class="d-inline-block">
    <x-button color="danger" type="submit"><i class="fas fa-trash"></i></x-button>
</x-form>