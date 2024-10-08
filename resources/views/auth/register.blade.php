 {{-- <x-guest-layout>
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
            {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
        {{-- </div> --}}

        <!-- Password -->
        {{-- <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> --}}

        <!-- Confirm Password -->
        {{-- <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" /> --}}

            {{-- <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /> --}}
        {{-- </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}
{{-- </x-guest-layout>   --}}




















    <form method="POST" action="{{ route('register') }}">
        @csrf
          
        <h2>Register Form</h2>
       
        <div>
            <label for="name" :value="__('Name')" ></label>
            <input id="name" class="block mt-1 w-full form-control" type="text" name="name" placeholder="Enter Your Name" :value="old('name')" required autofocus autocomplete="name" />
     
        </div><br><br>

        <div class="mt-4">
            <label for="email" :value="__('Email')" ></label>
            <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" placeholder="Enter Your Email" required autocomplete="username" />
            
        </div><br><br>

      
        <div class="mt-4">
            <label for="password" :value="__('Password')" ></label>

            <input id="password" class="block mt-1 w-full form-control"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Enter Your Password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            
        </div><br><br>

        <div class="mt-4">
            <label for="password_confirmation" :value="__('Confirm Password')" ></label>

            <input id="password_confirmation" class="block mt-1 w-full form-control"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Enter Your Confirm Pass.." />
                         
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /> 
          
        </div><br><br>

        <div class="flex items-center justify-end mt-4">
            <a  href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button  >
                {{ __('Register') }}
            </button>
        </div>
    </form> 



    <style>
  body{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }
    form{
        background: rgb(11, 138, 106);  
        align-items: center;
        justify-content: center;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        padding: 70px;
        border-radius: 20px;
        text-align: center;
    }

    #email{
        /* border-radius: 10px; */
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    #name{
        /* border-radius: 10px; */
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    

    #password{
        /* border-radius: 10px; */
        justify-content: center;
        align-items: center;
        text-align: center;
    }   
    #password_confirmation{
        /* border-radius: 10px; */
        justify-content: center;
        align-items: center; 
        text-align: center;
    }
    </style>