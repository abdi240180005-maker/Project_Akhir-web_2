<div class="sidebar">

    <div>

        <div class="logo">

            <div class="logo-icon">
                🌍
            </div>

            <div>

                <h5 class="mb-0 fw-bold">
                    GSCRI
                </h5>

                <small>
                    Global Risk System
                </small>

            </div>

        </div>

        <div class="menu mt-4">

            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i class="bi bi-speedometer2"></i>

                <span>Dashboard</span>

            </a>

            <a href="{{ route('countries.index') }}"
               class="{{ request()->routeIs('countries.*') ? 'active' : '' }}">

                <i class="bi bi-globe2"></i>

                <span>Countries</span>

            </a>

            <a href="{{ route('weather.index') }}"
               class="{{ request()->routeIs('weather.*') ? 'active' : '' }}">

                <i class="bi bi-cloud-sun"></i>

                <span>Weather</span>

            </a>

            <a href="#">

                <i class="bi bi-currency-exchange"></i>

                <span>Currency</span>

            </a>

            <a href="#">

                <i class="bi bi-graph-up"></i>

                <span>Economy</span>

            </a>

            <a href="#">

                <i class="bi bi-newspaper"></i>

                <span>News</span>

            </a>

            <a href="#">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <span>Risk Analysis</span>

            </a>

            <a href="#">

                <i class="bi bi-star-fill"></i>

                <span>Watchlist</span>

            </a>

        </div>

    </div>

    <div class="sidebar-footer">

        <div class="user-card">

            <strong>

                {{ Auth::user()->name }}

            </strong>

            <br>

            <small>

                Administrator

            </small>

        </div>

    </div>

</div>