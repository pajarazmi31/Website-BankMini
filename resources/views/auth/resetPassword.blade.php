<form action="{{ route('password.update') }}" method="POST">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <input
        type="email"
        name="email"
        value="{{ $email }}"
        readonly
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password Baru"
        required
    >

    <br><br>

    <input
        type="password"
        name="password_confirmation"
        placeholder="Konfirmasi Password"
        required
    >

    <br><br>

    <button type="submit">
        Simpan Password
    </button>
</form>