<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('sd/css/app.css')}}">
    <title>Login</title>
</head>

<body>
    <img class="shap1" src="{{asset('sd/asset/images/Ellipse 2b1.png')}}" alt="" srcset="">
    <img class="shap2" src="{{asset('sd/asset/images/Ellipse 2b1.png')}}" alt="" srcset="">
    <img class="shap3" src="{{asset('sd/asset/images/Ellipse 2b1.png')}}" alt="" srcset="">
    <div class="content">
        <div class="logoAndTitle">
            <img src="{{asset('sd/asset/images/logo.png')}}" alt="" srcset="">
            <img src="{{asset('sd/asset/images/aa.png')}}" alt="" srcset="">
        </div>
        <div class="container">


            <div class="row">
                <div class="welcomeSection col-md-7">
                    <div class="d-f-a">
                        <h1 class="z-card"></h1>
                    </div>
                    <h4>Please enter data</h4>
                </div>
                <div class="col-md-5 login">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mainTitleLogin">
                            <h2>Login</h2>
                            <div class="supTitle">Glad you're back.!</div>
                        </div>
                        <!-- inputs -->
                     

                        <div class="inputs">
                            <input id="email" type="email" placeholder="Email" class="userAndPassword @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <input id="password" type="password" placeholder="Password" class="userAndPassword @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                           
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            
                            
                            
                        </div >

                        <div class="btnLogin">
                            <button class="loginBtn" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
        integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="{{asset('sd/js/app.js')}}"></script>
</body>

</html>