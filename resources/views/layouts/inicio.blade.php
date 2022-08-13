<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
 
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    {{--JQuery--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        * {
  box-sizing: border-box;
  font-family: sans-serif;
}
.login {
  width: 320px;
  height: 450px;
  border: 1px solid #CCC;
  background: url(https://images.pexels.com/photos/957061/milky-way-starry-sky-night-sky-star-957061.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940) center center no-repeat;
  background-size: cover;
  margin: 30px auto;
  border-radius: 20px;
}
.login .form {
  width: 100%;
  height: 100%;
  padding: 15px 25px;
}
.login .form h2 {
  color: #FFF;
  text-align: center;
  font-weight: normal;
  font-size: 18px;
  margin-top: 60px;
  margin-bottom: 80px;
}

.login .form img{
    width:150px;
    height:150px;
    border-radius:50%;
    border: solid 3px white;
    overflow:hidden;
    margin-left: auto; 

margin-right: auto;

  opacity:0.4;

 
}
.login .form input {
  width: 100%;
  height: 40px;
  margin-top: 20px;
  background: rgba(255,255,255,.5);
  border: 1px solid rgba(255,255,255,.1);
  padding: 0 15px;
  color: #FFF;
  border-radius: 5px;
  font-size: 14px;
}
.login .form input:focus {
  border: 1px solid rgba(255,255,255,.8);
  outline: none;
}
::-webkit-input-placeholder {
    color: #aa2828;
}
.login .form input.submit {
  background: rgba(255,255,255,.9);
  color: #444;
  font-size: 15px;
  margin-top: 40px;
  font-weight: bold;
}

    </script>

</head>
<body class="w-full">
<div id="app">

    <div class="font-sans text-gray-900 antialiased">
        @yield('content')
    </div>
    @livewireScripts
    @stack('script')
</div>
</body>
</html>