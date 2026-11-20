<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="/assets/images/logo.svg">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>

                @if(session('success'))
                    <div class="alert alert-success py-2 mb-3 small">
                        <i class="mdi mdi-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif

                @error('email')
                    <div class="text-danger mb-2 small">
                        {{ $message }}
                    </div>
                @enderror
                <form class="pt-3" method="POST" action="{{route('authenticate')}}">
                    @CSRF
                  <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                   <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                        SIGN IN
                    </button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div>
                    <a href="#" class="auth-link text-primary">Forgot password?</a>
                  </div>
                 
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="{{route('register')}}" class="text-primary">Create</a>
                  </div>
                </form>

                <div class="mt-4 p-3 bg-light rounded text-start border small">
                  <div class="fw-bold text-dark mb-1"><i class="mdi mdi-key-outline text-primary me-1"></i> Comptes de test (MDP: <code>12345678</code>) :</div>
                  <ul class="mb-2 ps-3 text-muted">
                    <li><strong>Shop Y :</strong> <code>ahmed@gmail.com</code></li>
                    <li><strong>Shop X :</strong> <code>demo@barberchop.test</code></li>
                    <li><strong>Admin :</strong> <code>moustacharahmad@gmail.com</code></li>
                  </ul>
                  <a href="{{ route('setup.test.accounts') }}" class="btn btn-sm btn-outline-primary w-100 py-1">
                    <i class="mdi mdi-refresh me-1"></i> Réinitialiser les mots de passe (1-Click)
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
  </body>
</html>