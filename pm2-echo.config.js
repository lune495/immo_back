module.exports = {
    apps: [
      {
        name: 'laravel-echo-server',
        script: 'laravel-echo-server',
        args: 'start',
        cwd: '/var/www/html/immo_back', // Remplacez par votre chemin correct
        exec_mode: 'fork',
        instances: 1,
        autorestart: true,
        watch: false,
        max_memory_restart: '1G',
      }
    ]
  };