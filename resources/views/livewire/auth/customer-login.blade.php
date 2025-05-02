<div class="login-page min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>
        </div>
        <form wire:submit="login" class="mt-8 space-y-6">
            <div class="login-form rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none relative block w-full px-3 py-2 rounded-md placeholder-gray-500 text-gray-900 sm:text-sm"
                        placeholder="Email address">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required
                        class="appearance-none relative block w-full px-3 py-2 rounded-md placeholder-gray-500 text-gray-900 sm:text-sm"
                        placeholder="Password">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input wire:model="remember" id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 text-indigo-600 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="forgot-your-ppassword font-medium text-indigo-600 hover:text-indigo-500">
                        Forgot your password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Sign in
                </button>
            </div>

            <div class="text-sm text-center">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="{{ route('customer.register') }}" class="register-here font-medium text-indigo-600 hover:text-indigo-500">
                        Register here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div> 