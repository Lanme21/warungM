<x-home>
    <section class="min-h-screen">
        <div class="bg-top relative flex items-start pt-12 pb-56 m-4 overflow-hidden bg-cover min-h-50-screen rounded-xl" style="background-image: url('{{ asset('assets/img/background-baru.png') }}'); background-position: center;">
          <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-zinc-800 to-zinc-700 opacity-60"></span>
          <div class="container z-10">
            <div class="flex flex-wrap justify-center -mx-3">
              <div class="w-full max-w-full px-3 mx-auto mt-0 text-center lg:flex-0 shrink-0 lg:w-5/12">
                <h1 class="mt-12 mb-2 text-white">Hello!</h1>
                <p class="text-white">Silahkan daftarkan akun anda</p>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="flex flex-wrap -mx-3 -mt-48 md:-mt-56 lg:-mt-48">
            <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
              <div class="relative z-0 flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                <div class="p-6 mb-0 text-center bg-white border-b-0 rounded-t-2xl">
                  <h5>Register with</h5>
                </div>
                <div class="flex flex-wrap px-3 -mx-3 sm:px-6 xl:px-12">
                 
                  
                </div>
                <div class="flex-auto p-6">
                  <form role="form text-left" method="POST" action="register">
                    @csrf
                    <div class="mb-4">
                      <input type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Name" aria-label="Name" name="name" id="name" aria-describedby="email-addon" />
                       @error('name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                       @enderror
                    </div>
                    <div class="mb-4">
                      <input type="email" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Email" aria-label="Email" name="email" id="email" aria-describedby="email-addon" />
                       @error('email')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                       @enderror
                    </div>
                    <div class="mb-4">
                      <input type="password" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Password" aria-label="Password" name="password" id="password" aria-describedby="password-addon" />
                       @error('password')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                       @enderror    
                    </div>
                    <div class="mb-4">
                      <input type="password" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Password Configuration" aria-label="password_confirmation" name="password_confirmation" id="password_confirmation" aria-describedby="password-addon" />
                          @error('password_confirmation')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="min-h-6 pl-7 mb-0.5 block">
                      <input class="w-4.8 h-4.8 ease -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-blue-500 checked:to-violet-500 after:text-xxs after:font-awesome after:duration-250 after:ease-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-200 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100" type="checkbox" value="" checked />
                      <label class="mb-2 ml-1 font-normal cursor-pointer text-sm text-slate-700" for="flexCheckDefault"> I agree the <a href="javascript:;" class="font-bold text-slate-700">Terms and Conditions</a> </label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="inline-block w-full px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Sign up</button>
                    </div>
                    <p class="mt-4 mb-0 leading-normal text-sm">Already have an account? <a href="../pages/sign-in.html" class="font-bold text-slate-700">Sign in</a></p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</x-home>