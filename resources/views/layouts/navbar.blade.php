<nav class="top-navbar">

    <div class="left">

        <h4 class="mb-0 fw-bold">

            Dashboard

        </h4>

        <small class="text-muted">

            Global Supply Chain Risk Intelligence System

        </small>

    </div>

    <div class="right">

        <div class="date-box">

            {{ now()->format('d M Y') }}

        </div>


        <div class="profile">

            <div class="avatar">

                {{ strtoupper(substr(Auth::user()->name,0,1)) }}

            </div>

            <div>

                <strong>

                    {{ Auth::user()->name }}

                </strong>

                <br>

                <small>

                    Administrator

                </small>

            </div>

        </div>

        <form method="POST"
              action="{{ route('logout') }}">

            @csrf

            <button class="logout-btn">

                Logout

            </button>

        </form>

    </div>

</nav>