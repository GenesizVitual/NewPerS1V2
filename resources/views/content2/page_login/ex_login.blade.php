<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login/Sign-In</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="{{ asset('login_assets/css/style.css') }}">
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</head>

<body>
  <div class="logmod">
  <div class="logmod__wrapper">
    <span class="logmod__close">Close</span>
    <div class="logmod__container">
      <ul class="logmod__tabs">
        <li data-tabtar="lgm-2"><a href="#">Login</a></li>
        <li data-tabtar="lgm-1"><a href="#">Sign Up</a></li>
      </ul>
      <div class="logmod__tab-wrapper">
      <div class="logmod__tab lgm-1">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">Enter your personal details <strong>to create an acount</strong></span>
        </div>
        <div class="logmod__form">
          <form accept-charset="utf-8" action="{{ url('login_bpk') }}" method="post" class="simform">
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Email*</label>
                <input class="string optional" maxlength="255" id="user-email" placeholder="Email" type="email" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-pw">Password *</label>
                <input class="string optional" maxlength="255" id="user-pw" placeholder="Password" type="text" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Provinsi</label>
                <select class="js-example-basic-single" style="width: 100%" name="provinsi">
                  <option > Pilih Provinsi </option>
                  @foreach($provinsi as $val)
                    <option value="{{ $val->id }}"> {{ $val->province }} </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Kabupaten</label>
                <select class="js-example-basic-single" style="width: 100%" name="kabupaten">
                  <option > Pilih Kabupaten </option>
                  @foreach($kabupaten as $val)
                    <option value="{{ $val->id }}" > {{ $val->district }} </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="simform__actions">
              {{ csrf_field() }}
              <button class="sumbit" name="commit" type="sumbit" value="Create Account" ></button>
              <span class="simform__actions-sidetext">By creating an account you agree to our <a class="special" href="#" target="_blank" role="link">Terms & Privacy</a></span>
            </div>
          </form>
        </div>
        <div class="logmod__alter">
          <div class="logmod__alter-container">
            <a href="#" class="connect facebook">
              <div class="connect__icon">
                <i class="fa fa-facebook"></i>
              </div>
              <div class="connect__context">
                <span>Create an account with <strong>Facebook</strong></span>
              </div>
            </a>

            <a href="#" class="connect googleplus">
              <div class="connect__icon">
                <i class="fa fa-google-plus"></i>
              </div>
              <div class="connect__context">
                <span>Create an account with <strong>Google+</strong></span>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="logmod__tab lgm-2">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">Enter your email and password <strong>to sign in</strong>
            @if(Session::has('message_success'))
              <p style="color: green">{{ Session::get('message_success') }} </p>
            @endif

            @if(Session::has('message_fail'))
              <p style="color: red">{{ Session::get('message_fail') }} </p>
            @endif
          </span>
        </div>
        <div class="logmod__form">
          <form accept-charset="utf-8" action="{{ url('/') }}" method="post" class="simform">
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Email*</label>
                <input class="string optional" maxlength="255" id="user-email" placeholder="Email" name="email" type="email" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-pw">Password *</label>
                <input class="string optional" maxlength="255" id="user-pw" placeholder="Password" type="password" name="password" size="50" />
                						<span class="hide-password">Show</span>
              </div>
            </div>
            <div class="simform__actions">
              {{ csrf_field() }}
            <button class="sumbit" name="commit" type="sumbit" >Log In</button>
              <span class="simform__actions-sidetext"><a class="special" role="link" href="#">Forgot your password?<br>Click here</a></span>
            </div>
          </form>
        </div>
        <div class="logmod__alter">
          <div class="logmod__alter-container">
            <a href="#" class="connect facebook">
              <div class="connect__icon">
                <i class="fa fa-facebook"></i>
              </div>
              <div class="connect__context">
                <span>Sign in with <strong>Facebook</strong></span>
              </div>
            </a>
            <a href="#" class="connect googleplus">
              <div class="connect__icon">
                <i class="fa fa-google-plus"></i>
              </div>
              <div class="connect__context">
                <span>Sign in with <strong>Google+</strong></span>
              </div>
            </a>
          </div>
        </div>
          </div>
      </div>
    </div>
  </div>
</div>


    <script src="{{ asset('login_assets/js/index.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
</body>
</html>
