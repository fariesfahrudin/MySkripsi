<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen w-screen bg-slate-900 flex items-center justify-center p-4 overflow-hidden select-none">

    <div
        class="bg-gradient-to-b from-blue-800 to-indigo-950 p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(29,78,216,0.3)] w-full max-w-[380px] border border-blue-700/50 flex flex-col justify-between">

        <h2 class="text-xl font-bold text-center text-white mb-8 tracking-wide">Silahkan Login</h2>

        @if ($errors->any())
            <div class="mb-5 p-3 bg-red-600/90 text-white rounded-xl text-xs font-bold shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                             d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
                <input type="text" name="username" placeholder="Username" required
                    class="w-full pl-10 pr-4 py-3 border border-slate-900 rounded-xl bg-white text-slate-900 placeholder-slate-400 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-inner">
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" name="password" placeholder="Password" required
                    class="w-full pl-10 pr-4 py-3 border border-slate-900 rounded-xl bg-white text-slate-900 placeholder-slate-400 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-inner">
            </div>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </span>
                <select name="role" required
                    class="w-full pl-10 pr-10 py-3 border border-slate-900 rounded-xl bg-white text-slate-700 font-semibold appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm shadow-inner">
                    <option value="" class="text-slate-400 font-medium">Dropdown Admin atau Petugas</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <div class="pt-4 flex justify-center">
                <button type="submit"
                    class="w-44 bg-gradient-to-b from-blue-100 to-indigo-200 border border-blue-300 text-indigo-950 py-2.5 rounded-xl font-bold hover:from-white hover:to-blue-100 active:scale-[0.97] transition duration-150 shadow-md text-sm">
                    Login
                </button>
            </div>

        </form>

    </div>

</body>

</html>
