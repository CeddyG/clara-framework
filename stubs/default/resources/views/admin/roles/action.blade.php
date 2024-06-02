<a href="{{ route('admin.roles.edit', $id) }}">
    <x-button color="warning" type="submit"><i class="fas fa-edit"></i></x-button>
</a>

<x-form :action="route('admin.roles.destroy', $id)" onsubmit="javascript:return confirm('Voulez-vous vraiment supprimer ?')" method="delete" class="d-inline-block">
    <x-button color="danger" type="submit"><i class="fas fa-trash"></i></x-button>
</x-form>