module.exports = {
    apps: [
      {
        name: 'laravel-queue-worker',
        script: 'php',
        args: 'artisan queue:work --sleep=3 --tries=3',
        cwd: '/var/www/html/immo_back', // Assurez-vous que ce chemin est correct
        exec_mode: 'fork',
        instances: 1,
        autorestart: true,
        watch: false,
        max_memory_restart: '1G',
      }
    ]
  };  