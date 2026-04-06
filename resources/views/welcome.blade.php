<!doctype html>

<html lang="pt-br" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-template="horizontal-menu-template" data-style="light">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ env('APP_NAME') }} | {{ env('APP_DESCRIPTION') }}</title>
        <meta name="description" content=""/>

        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}"/>
        <link rel="preconnect" href="https://fonts.googleapis.com"/>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet"/>

        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/remixicon/remixicon.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}"/>

        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-statistics.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-analytics.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/shepherd/shepherd.css') }}"/>

        <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css"/>
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css"/>

        <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
        <script src="{{ asset('assets/js/mask.js') }}"></script>

        <style>
            body {
                background-image: url('{{ asset('assets/img/backgrounds/bg.png') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
            }
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: -1;
            }
        </style>
    </head>

    <body>
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
            <div class="layout-container">
                <div class="layout-page">
                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row g-6">
                                @if ($errors->any())
                                    <div class="alert alert-outline-danger" role="alert">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="col-12 col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                    <form action="{{ route('created-order') }}" method="POST" class="card p-5">
                                        @csrf
                                        <div class="row p-5">
                                            <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                <h4 class="text-info">MaisEduc Cursos Profissionalizantes</h4>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" name="name" class="form-control" placeholder="Nome completo" id="name" required/>
                                                    <label for="name">Nome completo</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-floating form-floating-outline mb-5">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required/>
                                                    <label for="email">E-mail</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-floating form-floating-outline mb-5">
                                                    <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" placeholder="CPF ou CNPJ" oninput="maskCpfCnpj(this)" required/>
                                                    <label for="cpfcnpj">CPF ou CNPJ</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-floating form-floating-outline mb-5">
                                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="CPF ou CNPJ" oninput="maskPhone(this)"/>
                                                    <label for="phone">Telefone</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card">
                                                    <h5 class="card-header">Qual a melhor opção para você?</h5>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md mb-md-0 mb-5">
                                                                <div class="form-check custom-option custom-option-basic checked">
                                                                    <label class="form-check-label custom-option-content" for="packageOne">
                                                                        <input name="package" class="form-check-input" type="radio" value="25" id="packageOne" checked>
                                                                        <span class="custom-option-header">
                                                                            <span class="h6 mb-0">Matrícula</span>
                                                                            <small class="text-muted">R$ 25,00</small>
                                                                        </span>
                                                                        <span class="custom-option-body">
                                                                            <small>Aproveite essa promoção!</small>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md">
                                                                <div class="form-check custom-option custom-option-basic">
                                                                    <label class="form-check-label custom-option-content" for="packageTwo">
                                                                        <input name="package" class="form-check-input" type="radio" value="480" id="packageTwo">
                                                                        <span class="custom-option-header">
                                                                            <span class="h6 mb-0">Curso Completo</span>
                                                                            <small class="text-muted">R$ 480,00</small>
                                                                        </span>
                                                                        <span class="custom-option-body">
                                                                            <small>Você fica livre de parcelas mensais!</small>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 d-grid mt-3 text-center">
                                                <button type="submit" class="btn btn-success">MATRICULAR-SE AGORA!</button>
                                                <div class="divider my-5">
                                                    <div class="divider-text">OU</div>
                                                </div>
                                                <a href="https://api.whatsapp.com/send?phone=5584991427908&text=Ol%C3%A1,%20vim%20atrav%C3%A9s%20do%20site%20e%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es" class="text-info mt-3">FALE COM UM DOS NOSSOS ATENDENTES</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <footer class="content-footer footer">
                            <div class="container-xxl">
                                <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                    <div class="text-white mb-2 mb-md-0">
                                        © Todos os direitos reservados | <a href="https://maiseducbr.com.br/" target="_blank" class="footer-link text-info">MaisEduc Cursos Profissionalizantes</a>
                                    </div>
                                    <div class="d-none d-lg-inline-block">
                                        <a href="" target="_blank" class="footer-link me-4 text-white">Termos & Condições</a>
                                        <a href="" target="_blank" class="footer-link d-none d-sm-inline-block text-white">Privacidade & Cookies</a>
                                    </div>
                                </div>
                            </div>
                        </footer>

                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>

        <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

        <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
        
        {{-- <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script> --}}
        <script src="{{ asset('assets/js/main.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/charts-apex.js') }}"></script>--}}
        <script src="{{ asset('assets/js/forms-selects.js') }}"></script> 
        
        {{-- <script src="{{ asset('assets/js/forms-tagify.js') }}"></script> --}}
        <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
        <script src="{{ asset('assets/js/ui-popover.js') }}"></script>
        
        @if (!empty($charts))
            <script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>
            <script src="{{ asset('assets/js/charts-chartjs.js') }}"></script>
        @endif
        
        <script>
            @if(session('error'))
                Swal.fire({
                    title: 'Erro!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    timer: 5000
                })
            @endif

            @if(session('infor'))
                Swal.fire({
                    title: 'Atenção!',
                    text: '{{ session('infor') }}',
                    icon: 'info',
                    timer: 5000
                })
            @endif
            
            @if(session('success'))
                Swal.fire({
                    title: 'Sucesso!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 5000
                })
            @endif

            @if(session('qrCodeImg') && session('invoiceUrl'))
                Swal.fire({
                    title: 'Pague com PIX',
                    html: `
                        <div style="text-align:center;">
                            <img src="{{ session('qrCodeImg') }}" 
                                style="width:250px;height:250px;border-radius:10px;" />
                            <br><br>
                            <div class="d-flex justify-content-center gap-2">
                                <button id="btn-copy-pix" onClick="onClip('{{ session('qrCode') }}')" class="btn btn-outline-success">
                                    Copiar Código PIX
                                </button>
                                <a id="btn-boleto" href="{{ session('invoiceUrl') }}" target="_blank" class="btn btn-outline-dark">
                                    Acessar Boleto
                                </a>
                            </div>
                        </div>
                    `,
                    width: 420,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                })
            @endif

            document.addEventListener('DOMContentLoaded', function () {
                applyMasks(document);
                document.querySelectorAll('form.delete').forEach(form => {
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Tem certeza?',
                            text: 'Você realmente deseja excluir este registro?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sim',
                            confirmButtonColor: '#008000',
                            cancelButtonText: 'Não',
                            cancelButtonColor: '#FF0000',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('form.confirm').forEach(form => {
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();

                        Swal.fire({
                            title: 'Confirme sua senha!',
                            text: 'Para continuar, digite sua senha.',
                            icon: 'info',
                            input: 'password',
                            inputPlaceholder: 'Digite sua senha',
                            inputAttributes: {
                                autocapitalize: 'off',
                                autocorrect: 'off'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Confirmar',
                            confirmButtonColor: '#008000',
                            cancelButtonText: 'Cancelar',
                            cancelButtonColor: '#FF0000',
                            preConfirm: (password) => {
                                if (!password) {
                                    Swal.showValidationMessage('Senha é obrigatória!');
                                }
                                return password;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'password';
                                input.value = result.value;
                                form.appendChild(input);

                                form.submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('input[type="file"].submit').forEach(input => {
                    input.addEventListener("change", function() {
                        this.closest("form").submit();
                    });
                });
            });

            $(document).on('shown.bs.modal', '.modal', function () {
                applyMasks(this);
            });

            function applyMasks(context) {
                context.querySelectorAll('.money').forEach(el => el.value && maskValue(el));
                context.querySelectorAll('.performance').forEach(el => el.value && maskPerformance(el));
                context.querySelectorAll('.phone').forEach(el => el.value && maskPhone(el));
                context.querySelectorAll('.cpfcnpj').forEach(el => el.value && maskCpfCnpj(el));
                context.querySelectorAll('.address').forEach(el => el.value && consultAddress(el));
            }

            function onClip(text) {
                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Link copiado',
                        icon: 'success',
                        timer: 5000
                    });
                }).catch(err => {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Link não copiado, tente novamente!',
                        icon: 'error',
                        timer: 5000
                    });
                });
            }
        </script>
    </body>
</html>