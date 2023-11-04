<header class="header">


      <nav class="navbar navbar-expand-lg" id="navbar">
        <div class="container">
          <a class="navbar-brand" href="https://whoicard.com/info/">
            <img src="{{ asset('storage/img/logo/Logo.webp') }}" alt="Logo" width="70%" class="img-fluid img-sm">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            {{-- <ul class="navbar-nav a2a_kit a2a_kit_size_32 a2a_default_style">
              <li class="nav-item navlink" >
                <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
              </li>
              <li class="nav-item navlink">
                <a class="a2a_button_copy_link"></a>
              </li>
              <li class="nav-item navlink">
                <a class="a2a_button_whatsapp"></a>
              </li> --}}
              <li class="nav-item form-check form-switch " > <input type="checkbox" class="form-check-input" id="darkSwitch">
                {{-- <label class="custom-control-label" for="darkSwitch">Dark Mode</label> </li> --}}
            </ul>

          </div>
        </div>
      </nav>

      <script>
        var a2a_config = a2a_config || {};
        a2a_config.onclick = 1;
        a2a_config.num_services = 22;
      </script>
      <script async src="https://static.addtoany.com/menu/page.js"></script>

</header>
