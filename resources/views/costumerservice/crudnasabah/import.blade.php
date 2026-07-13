

<form action="{{ route('import.nasabah') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="file">

    <button>Import</button>
</form>
