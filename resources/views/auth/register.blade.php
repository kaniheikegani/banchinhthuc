<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

         <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Vai trò')" />
            <select id="role" name="role" class="block mt-1 w-full" required onchange="toggleSecurityCode(this.value)">
                <option value="student">Học sinh</option>
                <option value="teacher">Giáo viên</option>
                <option value="admin">Quản trị viên</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Security Code (hidden unless teacher/admin) -->
        <div class="mt-4" id="security-code-field" style="display: none;">
            <x-input-label for="security_code" :value="__('Mã bảo mật')" />
            <x-text-input id="security_code" class="block mt-1 w-full" type="text" name="security_code"
                          :value="old('security_code')" autocomplete="off" />
            <x-input-error :messages="$errors->get('security_code')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

            <!-- Script to toggle security code field -->
        <script>
            function toggleSecurityCode(role) {
                const field = document.getElementById('security-code-field');
                field.style.display = (role === 'teacher' || role === 'admin') ? 'block' : 'none';
            }

            document.addEventListener('DOMContentLoaded', function () {
                const roleSelect = document.getElementById('role');
                toggleSecurityCode(roleSelect.value);
                roleSelect.addEventListener('change', function () {
                    toggleSecurityCode(this.value);
                });
            });
        </script>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
