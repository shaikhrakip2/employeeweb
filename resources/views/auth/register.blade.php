 <x-guest-layout>
    <form method="POST" action="{{ route('register') }}" >
        @csrf
        <!-- Name -->
        <div >
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Enter Your Name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Enter Your Email" required autocomplete="username" />
             <x-input-error :messages="$errors->get('email')" class="mt-2" /> 
        </div>

        <!-- Password -->
       <div class="mt-4 ">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Enter Your Password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> 

        <!-- Confirm Password -->
         <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            placeholder="Enter Your Confirm-Password"
                            name="password_confirmation" required autocomplete="new-password" /> 

           <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /> 
        </div>

        <div class="flex items-center justify-center" style="flex; margin-top: 35px; padding:20px; box-sizing: border-box; ">
            {!!htmlFormSnippet()!!}

            @if($errors->has('g-recaptcha-response') )
            <div>
                <small class="text-danger">
                    {{ $errors->first('g-recaptcha-response') }}
                </small>
            </div>

            @endif
        </div>
        

        <div class="flex items-center justify-end">
            <a class="underline text-sm text-white  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> 
 </x-guest-layout>  






 




