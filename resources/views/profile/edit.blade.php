<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Profile</title>
</head>

<body>
    <main style="max-width: 640px; margin: 2rem auto; padding: 0 1rem; font-family: sans-serif;">
        <h1>Update Profile</h1>

        @if (session('status'))
            <p style="color: #0a7d2c;">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" style="display: grid; gap: 1rem;">
            @csrf
            @method('PATCH')

            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <p style="color: #b50000; margin-top: -0.5rem;">{{ $message }}</p>
            @enderror

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <p style="color: #b50000; margin-top: -0.5rem;">{{ $message }}</p>
            @enderror

            <button type="submit">Save changes</button>
        </form>
    </main>
</body>

</html>
