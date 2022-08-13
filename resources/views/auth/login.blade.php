
<html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>TechPeru</title>
      <link 
        rel="stylesheet" 
        href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" /> 
        
        <style>
          body{
            background: darkgray;
          }
           * {
    box-sizing: border-box;
    font-family: sans-serif;
  }
  .login {
    width: 320px;
    height: 450px;
    border: 1px solid #CCC;
    box-shadow: 10px 5px 5px gray;
    background: url(https://images.pexels.com/photos/3473569/pexels-photo-3473569.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940) center center no-repeat;
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
    font-weight: bold;
    font-size: 15px;
    margin-top: 40px;
    font-weight: bold;
  }
  
        </style>
    </head>
    <body>   
      <div class="login">
        @if (session('info'))
        <div class="alert alert-success">
            {{session('info')}}
        </div>
        @endif
          <div class="form">
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <img class="mb-4" src="storage/logo/logo.png" alt="">
  
              <input type="email" name="email"  id="email" placeholder="Email" required>
              <x-input-error for="email" />
              <input type="password" id="password" name="password" required placeholder="Contraseña">
              <x-input-error for="password" />
              <x-button class="mt-6 w-full">
                {{ __('Ingresar') }}
            </x-button>

              </form>
              
          </div>
        </div>
      
    </body>
  
