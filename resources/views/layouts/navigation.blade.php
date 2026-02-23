<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left: Logo + Navigation -->
            <div class="flex items-center flex-grow">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-12 sm:flex">
                    @hasSection('nav-links')
                        @yield('nav-links')
                    @else
                        @if(Auth::check() && Auth::user()->hasRole('student'))
                            {{-- menu student --}}
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Trang Chủ</x-nav-link>
                            <x-nav-link :href="route('student.profile')" :active="request()->routeIs('student.profile')">Thông tin cá nhân</x-nav-link>
                            <x-nav-link :href="route('student.schedules')" :active="request()->routeIs('student.schedules')">Lịch học</x-nav-link>
                            <x-nav-link :href="route('student.scores')" :active="request()->routeIs('student.scores')">Điểm</x-nav-link>
                            <x-nav-link :href="route('student.classroom.chat', Auth::user()->classroom->id)" 
                                        :active="request()->routeIs('student.classroom.chat')">Nhóm chat</x-nav-link>
                            <x-nav-link :href="route('student.requests.index')" :active="request()->routeIs('student.requests.index')">Đề xuất</x-nav-link>

                        @elseif(Auth::check() && Auth::user()->hasRole('admin'))
                            {{-- menu admin --}}
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Trang Chủ</x-nav-link>
                            <x-nav-link :href="route('admin.students')" :active="request()->routeIs('admin.students')">Quản lý học sinh</x-nav-link>
                            <x-nav-link :href="route('admin.scores')" :active="request()->routeIs('admin.scores')">Quản lý điểm</x-nav-link>
                            <x-nav-link :href="route('admin.classrooms')" :active="request()->routeIs('admin.classrooms')">Quản lý Lớp Học</x-nav-link>
                            <x-nav-link :href="route('admin.schedules.index')" :active="request()->routeIs('admin.schedules.index')">Quản lý Lịch Học</x-nav-link>
                            <x-nav-link :href="route('admin.home.edit')" :active="request()->routeIs('admin.home.edit')">Quản lý Trang chủ</x-nav-link>
                            <!-- Nút Xem thêm -->
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">+ Xem thêm</x-nav-link>

                        @elseif(Auth::check() && Auth::user()->hasRole('teacher'))
                            {{-- menu teacher --}}
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Trang Chủ</x-nav-link>
                            <x-nav-link :href="route('teacher.students')" :active="request()->routeIs('teacher.students')">Danh sách học sinh</x-nav-link>
                            <x-nav-link :href="route('teacher.scores.view')" :active="request()->routeIs('teacher.scores.view')">Điểm lớp chủ nhiệm</x-nav-link>
                            <x-nav-link :href="route('teacher.scores.input')" :active="request()->routeIs('teacher.scores.input')">Nhập điểm lớp phân công</x-nav-link>
                            <x-nav-link :href="route('teacher.classrooms')" :active="request()->routeIs('teacher.classrooms')">Quản lý nhóm lớp</x-nav-link>
                            <x-nav-link :href="route('teacher.schedules')" :active="request()->routeIs('teacher.schedules')">Lịch dạy</x-nav-link>
                            <!-- Nút Xem thêm -->
                            <x-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.dashboard')">+ Xem thêm</x-nav-link>
                        @else
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Trang Chủ</x-nav-link>
                        @endif
                    @endif
                </div>
            </div>
            <!-- Right: Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile Cá Nhân') }}
                            </x-dropdown-link>

                            @if (Auth::user()->hasRole('admin'))
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    {{ __('Quản trị') }}
                                </x-dropdown-link>
                            @elseif (Auth::user()->hasRole('teacher'))
                                <x-dropdown-link :href="route('teacher.dashboard')">
                                    {{ __('Giáo viên') }}
                                </x-dropdown-link>
                            @elseif (Auth::user()->hasRole('student'))
                                <x-dropdown-link :href="route('student.dashboard')">
                                    {{ __('Học sinh') }}
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    @if (Route::has('login'))
                        <nav class="flex items-center gap-4">
                            <a href="{{ route('login') }}"
                               class="inline-block px-5 py-1.5 text-sm text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A] rounded-sm leading-normal">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-block px-5 py-1.5 text-sm text-[#1b1b18] border border-[#19140035] hover:border-[#1915014a] dark:text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm leading-normal">
                                    Register
                                </a>
                            @endif
                        </nav>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @php $role = Auth::user()->role ?? null; @endphp

            @if($role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @elseif($role === 'teacher')
                <x-responsive-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @elseif($role === 'student')
                <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>