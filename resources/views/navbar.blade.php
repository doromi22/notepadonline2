<h1 class="h1title"><a href="/">Notepad Online</a></h1>

<ul class="navbardiv">
    <li class="navbaritems"><a href="/write">write</a></li>
    <li class="navbaritems"><a href="/history">history</a></li>
    <!-- 로그인한 사용자를 위한 코드 -->
    @auth
        <li class="navbaritems"><a href="/logout">Logout</a></li>
        <li class="navbaritems">
            Welcome, {{ Auth::user()->name }}!
            <form action="{{ route('user.delete') }}" method="POST" onsubmit="return confirmDelete()" class="delete-account-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-account-button">Delete Account</button>
            </form>
        </li>
    @endauth

    <!-- 로그인하지 않은 사용자를 위한 코드 -->
    @guest
        <li class="navbaritems"><a href="/register">Register</a></li>
        <li class="navbaritems"><a href="/login">Login</a></li>
    @endguest
</ul>
