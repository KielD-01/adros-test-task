# Adros Test Task

## Requirements 
- NPM / Yarn    
- PHP 7.1+  
- ImageMagick (w/ php-imagick)  
- GhostScript   
- Composer  

## Installation

```bash
git clone git@github.com:KielD-01/adros-test-task.git adros.test
cd adros test
cp .env.example .env
composer install
npm i; npm run prod
```

Don't forget to put Your data into the .env about the Database, before running migration, because it might run You into an issue.

Then, You need to create Database named `adros_test` and run next command:
```bash
php artisan migrate
```

After, You can run `php artisan serve` and try it out on Your local machine.

## Notes
- You don't need to run `npm i` with afterward commands, like `npm run prod`, 'npm run dev` or `npm run watch`, if You are not going to change JS files or Vue Components within the front-end