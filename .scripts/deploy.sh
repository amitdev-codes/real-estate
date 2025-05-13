#!/bin/bash
set -e
set -x  # Print each command before it runs for debugging

echo "🛸 Deployment started ..."

# Check if inside a Git repository and if 'dev' branch exists
cd ~/public_html/website_436cef92 || { echo "❌ Directory change failed"; exit 1; }
echo "Current directory: $(pwd)"

if [ ! -d ".git" ]; then
    echo "❌ Error: Not in a Git repository."
    exit 1
fi

if ! git show-ref --quiet refs/heads/dev; then
    echo "❌ Error: Branch 'dev' does not exist."
    exit 1
fi

# Switch to 'dev' branch
git checkout dev

# Set upstream branch if not set
if ! git rev-parse --abbrev-ref --symbolic-full-name @{u} > /dev/null 2>&1; then
    echo "Setting upstream branch for 'dev'..."
    git branch --set-upstream-to=origin/dev dev
fi

# Reset the remote workspace to match the remote 'dev' branch (to avoid merge conflicts)
echo "Resetting remote workspace..."
git fetch origin
git reset --hard origin/dev || { echo "❌ Git reset failed"; exit 1; }

# Maintenance mode
php artisan down --message="The site is under maintenance. Please check back soon!" || true

# Pull the latest version of the app from the 'dev' branch
git pull origin dev || { echo "❌ Git pull failed"; exit 1; }

# Composer update and installation
/home4/migratn9/composer self-update
/home4/migratn9/composer update --no-dev --no-interaction --prefer-dist --optimize-autoloader || { echo "❌ Composer update failed"; exit 1; }
/home4/migratn9/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || { echo "❌ Composer install failed"; exit 1; }

# NPM commands (halted for now)
echo "NPM commands halted for manual execution"

# Copy the .env.example to .env
cp .env.example .env || { echo "❌ .env copy failed"; exit 1; }

# Artisan commands
php artisan key:generate || { echo "❌ Artisan key:generate failed"; exit 1; }
php artisan migrate --force || { echo "❌ Database migration failed"; exit 1; }
php artisan optimize:clear || { echo "❌ Artisan optimize failed"; exit 1; }

# Permissions
chmod -R 775 ~/public_html || { echo "❌ chmod public_html failed"; exit 1; }
chmod -R 775 ~/public_html/website_436cef92/storage || { echo "❌ chmod storage failed"; exit 1; }
chmod -R 775 ~/public_html/website_436cef92/bootstrap/cache || { echo "❌ chmod cache failed"; exit 1; }

# Exit maintenance mode
php artisan up || { echo "❌ Artisan up failed"; exit 1; }

echo "🏁 Deployment finished! 👏🍾🎉🎊🎆"
