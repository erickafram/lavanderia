<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirecionarMotorista
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $usuario = auth()->user();

        // Verifica se o usuário é motorista
        if ($usuario->nivelAcesso && $usuario->nivelAcesso->nome === 'Motorista') {
            // Lista de rotas permitidas para motoristas
            $rotasPermitidas = [
                'motorista.dashboard',
                'motorista.buscar-empacotamento',
                'motorista.confirmar-saida',
                'motorista.confirmar-entrega',
                'logout'
            ];

            $rotaAtual = $request->route()->getName();

            // Se não está em uma rota permitida, redireciona para o dashboard do motorista
            if (!in_array($rotaAtual, $rotasPermitidas)) {
                return redirect()->route('motorista.dashboard');
            }
        }

        return $next($request);
    }
}
