
<div class="max-w-md mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Lupa Password</h1>

    @if(session('status'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <label>Email</label>

        <input
            type="email"
            name="email"
            class="w-full border rounded p-2 mt-2"
            required
        >

        <button
            type="submit"
            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
            Kirim Link Reset
        </button>
    </form>
</div>

