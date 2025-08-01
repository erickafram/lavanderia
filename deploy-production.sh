#!/bin/bash

echo "🚀 DEPLOY LAVANDERIA - PRODUÇÃO"
echo "================================"

# 1. Limpar todos os caches primeiro
echo "📝 Limpando caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear

# 2. Executar migrations (se houver)
echo "🗄️ Executando migrations..."
php artisan migrate --force

# 3. Recriar caches otimizados
echo "⚡ Otimizando para produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 4. Verificar permissões
echo "🔐 Ajustando permissões..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "✅ Deploy concluído!"
echo "🌐 Acesse: http://seu-dominio.com"
