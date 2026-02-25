<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar -->
     @auth
    <aside class="w-64 bg-white shadow-md p-6 flex flex-col">
        <h1 class="text-2xl font-bold mb-8">EasyColoc</h1>
        <nav class="flex flex-col gap-3">
            <a href="{{ route('dashboard') }}" class="hover:bg-blue-500 hover:text-white p-2 rounded">Dashboard</a>
            <a href="{{ route('colocation.index') }}" class="hover:bg-blue-500 hover:text-white p-2 rounded">Colocations</a>
            <a href="#" class="hover:bg-blue-500 hover:text-white p-2 rounded">Catégories</a>
            <a href="#" class="hover:bg-blue-500 hover:text-white p-2 rounded">Profil</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="bg-red-500 text-white w-full p-2 rounded hover:bg-red-600">Logout</button>
            </form>
        </nav>
    </aside>
    @endauth
     @guest
    <aside class="w-64 bg-white shadow-md p-6 flex flex-col">
        <nav class="flex flex-col gap-3">
                    <h1 class="text-2xl font-bold mb-8">EasyColoc</h1>
        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Login</a>
        <a href="{{ route('register') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Register</a>
        </nav>
    </aside>
    @endguest
    <!-- Main Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</body>
</html>