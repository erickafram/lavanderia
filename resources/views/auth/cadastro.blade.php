<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro - Sistema de Gestão de Lavanderia</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        .cadastro-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.175);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card cadastro-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                            <h3 class="card-title">Cadastro de Usuário</h3>
                            <p class="text-muted">Sistema de Gestão de Lavanderia</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('cadastro.post') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">
                                        <i class="fas fa-user me-2"></i>Nome Completo
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" 
                                           name="nome" 
                                           value="{{ old('nome') }}" 
                                           required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label">
                                        <i class="fas fa-phone me-2"></i>Telefone
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('telefone') is-invalid @enderror" 
                                           id="telefone" 
                                           name="telefone" 
                                           value="{{ old('telefone') }}" 
                                           placeholder="(11) 99999-9999">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">
                                        <i class="fas fa-id-card me-2"></i>CPF
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" 
                                           name="cpf" 
                                           value="{{ old('cpf') }}" 
                                           placeholder="000.000.000-00">
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nivel_acesso_id" class="form-label">
                                    <i class="fas fa-shield-alt me-2"></i>Nível de Acesso
                                </label>
                                <select class="form-select @error('nivel_acesso_id') is-invalid @enderror" 
                                        id="nivel_acesso_id" 
                                        name="nivel_acesso_id" 
                                        required>
                                    <option value="">Selecione um nível de acesso</option>
                                    @foreach($niveisAcesso as $nivel)
                                        <option value="{{ $nivel->id }}" {{ old('nivel_acesso_id') == $nivel->id ? 'selected' : '' }}>
                                            {{ $nivel->nome }} - {{ $nivel->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nivel_acesso_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Senha
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirmar Senha
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Cadastrar
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted">Já tem uma conta?</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Fazer Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
