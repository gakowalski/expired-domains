# expired-domains

## Setting crontab

```bash
crontab -e
```

Add new line, insert proper path:

```
0 3 * * * /usr/bin/php -f /var/www/html/expired-domains/index.php &> /dev/null
```

Script will be executed every 3 o'clock after morning. 