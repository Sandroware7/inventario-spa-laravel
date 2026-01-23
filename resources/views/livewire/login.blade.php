<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card shadow border-0" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5">
            <h3 class="text-center fw-bold mb-4">Iniciar Sesión</h3>

            <form wire:submit="login">
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" wire:model="email" class="form-control" placeholder="" autofocus>
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" wire:model="password" class="form-control" placeholder="">
                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    <span wire:loading.remove>Entrar</span>
                    <span wire:loading class="spinner-border spinner-border-sm"></span>
                </button>
            </form>

            <div class="text-center mt-3">
                <small>¿No tienes cuenta?
                    <a href="{{ route('register') }}" wire:navigate class="fw-bold">Regístrate aquí</a>
                </small>
            </div>
        </div>
    </div>
</div>
